
<?php

require_once __DIR__ . '/../config/db_connection.php';

$config = require __DIR__ . '/../config/payhere_config.php';

$merchantId = trim((string)($config['merchant_id'] ?? ''));
$merchantSecret = trim((string)($config['merchant_secret'] ?? ''));

function logPayHere(string $message): void
{
    error_log('[PayHere notify] ' . $message);
}

if (
    $merchantId === '' ||
    $merchantSecret === '' ||
    $merchantSecret === 'MzQ0ODg1MzkzMjE3NzU1Njg4OTkzMTU5ODQ1OTkwMTgwNTA0MzQ3T'
) {
    http_response_code(500);
    logPayHere('PayHere credentials are not configured.');
    exit('Configuration error');
}

$data = $_POST;

$required = [
    'merchant_id',
    'order_id',
    'payhere_amount',
    'payhere_currency',
    'status_code',
    'md5sig'
];

foreach ($required as $key) {
    if (!isset($data[$key]) || $data[$key] === '') {
        http_response_code(400);
        logPayHere('Missing field: ' . $key);
        exit('Missing notification data');
    }
}

$receivedMerchantId = (string)$data['merchant_id'];
$orderId = filter_var($data['order_id'], FILTER_VALIDATE_INT);
$amount = (string)$data['payhere_amount'];
$currency = (string)$data['payhere_currency'];
$statusCode = (string)$data['status_code'];
$receivedSignature = strtoupper((string)$data['md5sig']);

if (!$orderId || !is_numeric($amount) || !is_finite((float)$amount)) {
    http_response_code(400);
    exit('Invalid notification data');
}

$localSignature = strtoupper(
    md5(
        $receivedMerchantId .
        $orderId .
        $amount .
        $currency .
        $statusCode .
        strtoupper(md5($merchantSecret))
    )
);

if (!hash_equals($localSignature, $receivedSignature)) {
    http_response_code(400);
    logPayHere('Signature verification failed.');
    exit('Invalid signature');
}

if (!hash_equals($merchantId, $receivedMerchantId)) {
    http_response_code(400);
    logPayHere('Merchant ID mismatch.');
    exit('Invalid merchant');
}

if ($currency !== 'LKR') {
    http_response_code(400);
    logPayHere('Currency mismatch.');
    exit('Invalid currency');
}

try {
    $conn->begin_transaction();

    $stmt = $conn->prepare(
        "SELECT total_amount, payment_method, payment_status
         FROM orders
         WHERE order_id = ?
         FOR UPDATE"
    );

    if (!$stmt) {
        throw new RuntimeException('Could not prepare order query.');
    }

    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$order) {
        $conn->rollback();
        http_response_code(404);
        exit('Order not found');
    }

    if (strtolower((string)$order['payment_method']) !== 'card') {
        $conn->rollback();
        http_response_code(400);
        exit('Not a card order');
    }

    $savedAmount = number_format(
        (float)$order['total_amount'],
        2,
        '.',
        ''
    );

    $receivedAmount = number_format(
        (float)$amount,
        2,
        '.',
        ''
    );

    if ($savedAmount !== $receivedAmount) {
        $conn->rollback();
        logPayHere('Payment amount mismatch for order ' . $orderId);
        http_response_code(400);
        exit('Amount mismatch');
    }

    $paymentId = isset($data['payment_id'])
        ? trim((string)$data['payment_id'])
        : '';

    if ($statusCode === '2') {
        // Do not overwrite an order that has already been marked paid.
        if (strtolower((string)$order['payment_status']) !== 'paid') {
            $stmt = $conn->prepare(
                "UPDATE orders
                 SET payment_status = 'Paid',
                     status = 'Processing',
                     payment_reference = ?
                 WHERE order_id = ?"
            );

            if (!$stmt) {
                throw new RuntimeException('Could not prepare paid update.');
            }

            $stmt->bind_param('si', $paymentId, $orderId);
            $stmt->execute();
            $stmt->close();
        }
    } elseif ($statusCode === '-1') {
        if (strtolower((string)$order['payment_status']) !== 'paid') {
            $stmt = $conn->prepare(
                "UPDATE orders
                 SET payment_status = 'Cancelled',
                     status = 'Cancelled',
                     payment_reference = ?
                 WHERE order_id = ?"
            );

            if (!$stmt) {
                throw new RuntimeException('Could not prepare cancel update.');
            }

            $stmt->bind_param('si', $paymentId, $orderId);
            $stmt->execute();
            $stmt->close();
        }
    } elseif ($statusCode === '-2') {
        if (strtolower((string)$order['payment_status']) !== 'paid') {
            $stmt = $conn->prepare(
                "UPDATE orders
                 SET payment_status = 'Failed',
                     payment_reference = ?
                 WHERE order_id = ?"
            );

            if (!$stmt) {
                throw new RuntimeException('Could not prepare failed update.');
            }

            $stmt->bind_param('si', $paymentId, $orderId);
            $stmt->execute();
            $stmt->close();
        }
    } elseif ($statusCode === '-3') {
        $stmt = $conn->prepare(
            "UPDATE orders
             SET payment_status = 'Chargedback',
                 status = 'Payment Review',
                 payment_reference = ?
             WHERE order_id = ?"
        );

        if (!$stmt) {
            throw new RuntimeException('Could not prepare chargeback update.');
        }

        $stmt->bind_param('si', $paymentId, $orderId);
        $stmt->execute();
        $stmt->close();
    } else {
        // Unknown status codes are logged and not treated as success.
        logPayHere('Unhandled status code: ' . $statusCode);
    }

    $conn->commit();

    http_response_code(200);
    echo 'OK';

} catch (Throwable $e) {
    try {
        $conn->rollback();
    } catch (Throwable $ignored) {
        // Transaction may already have been rolled back.
    }

    logPayHere('Notification processing failed: ' . $e->getMessage());

    http_response_code(500);
    echo 'Notification processing failed';
}
