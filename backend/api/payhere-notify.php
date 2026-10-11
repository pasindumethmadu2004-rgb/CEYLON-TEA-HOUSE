
<?php

require_once __DIR__ . '/../config/db_connection.php';

$config = require __DIR__ . '/../config/payhere_config.php';

$merchantId = trim((string)($config['merchant_id'] ?? ''));
$merchantSecret = trim((string)($config['merchant_secret'] ?? ''));

function notifyLog(string $message): void
{
    error_log('[PayHere] ' . $message);
}

function notifyExit(int $status, string $message): void
{
    http_response_code($status);
    echo $message;
    exit;
}

if (
    $merchantId === '' ||
    $merchantSecret === '' ||
    $merchantSecret === 'PASTE_NEW_MERCHANT_SECRET_HERE'
) {
    notifyExit(500, 'PayHere configuration error');
}

$required = [
    'merchant_id',
    'order_id',
    'payhere_amount',
    'payhere_currency',
    'status_code',
    'md5sig'
];

foreach ($required as $key) {
    if (!isset($_POST[$key]) || $_POST[$key] === '') {
        notifyExit(400, 'Missing notification field');
    }
}

$receivedMerchantId = (string)$_POST['merchant_id'];
$orderId = filter_var($_POST['order_id'], FILTER_VALIDATE_INT);
$amount = (string)$_POST['payhere_amount'];
$currency = (string)$_POST['payhere_currency'];
$statusCode = (string)$_POST['status_code'];
$receivedSignature = strtoupper((string)$_POST['md5sig']);

if (
    $orderId === false ||
    $orderId === null ||
    $orderId < 1 ||
    !is_numeric($amount) ||
    !is_finite((float)$amount) ||
    (float)$amount < 0
) {
    notifyExit(400, 'Invalid notification data');
}

$expectedSignature = strtoupper(md5(
    $receivedMerchantId .
    (string)$orderId .
    $amount .
    $currency .
    $statusCode .
    strtoupper(md5($merchantSecret))
));

if (!hash_equals($expectedSignature, $receivedSignature)) {
    notifyLog('Invalid notification signature.');
    notifyExit(400, 'Invalid signature');
}

if (
    !hash_equals($merchantId, $receivedMerchantId) ||
    $currency !== 'LKR'
) {
    notifyExit(400, 'Merchant or currency mismatch');
}

$paymentId = trim((string)($_POST['payment_id'] ?? ''));

try {
    $conn->begin_transaction();

    $stmt = $conn->prepare(
        'SELECT total_amount, payment_method, payment_status, status
         FROM orders
         WHERE order_id = ?
         FOR UPDATE'
    );
    $stmt->bind_param('i', $orderId);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$order) {
        $conn->rollback();
        notifyExit(404, 'Order not found');
    }

    if (strtolower((string)$order['payment_method']) !== 'card') {
        $conn->rollback();
        notifyExit(400, 'Not a card order');
    }

    $expectedAmount = number_format(
        (float)$order['total_amount'],
        2,
        '.',
        ''
    );
    $receivedAmount = number_format((float)$amount, 2, '.', '');

    if ($expectedAmount !== $receivedAmount) {
        $conn->rollback();
        notifyLog('Amount mismatch for order ' . $orderId);
        notifyExit(400, 'Amount mismatch');
    }

    $currentPaymentStatus = strtolower(
        (string)$order['payment_status']
    );
    $currentOrderStatus = strtolower((string)$order['status']);

    if ($statusCode === '2') {
        /*
         * Do not revive an order whose stock has already been released.
         */
        if (
            in_array($currentPaymentStatus, ['cancelled', 'failed'], true) ||
            $currentOrderStatus === 'cancelled'
        ) {
            $conn->rollback();
            notifyLog(
                'Successful notification received after order cancellation: '
                . $orderId
            );
            notifyExit(409, 'Order is already cancelled or failed');
        }

        if ($currentPaymentStatus !== 'paid') {
            $stmt = $conn->prepare(
                "UPDATE orders
                 SET payment_status = 'Paid',
                     status = 'Processing',
                     payment_reference = ?
                 WHERE order_id = ?"
            );
            $stmt->bind_param('si', $paymentId, $orderId);
            $stmt->execute();
            $stmt->close();
        }

    } elseif ($statusCode === '-1' || $statusCode === '-2') {
        /*
         * Release reserved stock only on the first transition from Pending.
         * Order-row locking plus the status check prevents duplicate release.
         */
        if ($currentPaymentStatus === 'pending') {
            $itemStmt = $conn->prepare(
                'SELECT product_id, quantity
                 FROM order_items
                 WHERE order_id = ?'
            );
            $itemStmt->bind_param('i', $orderId);
            $itemStmt->execute();
            $itemsResult = $itemStmt->get_result();

            $stockStmt = $conn->prepare(
                'UPDATE products
                 SET stock_qty = stock_qty + ?
                 WHERE product_id = ?'
            );

            while ($item = $itemsResult->fetch_assoc()) {
                $quantity = (int)$item['quantity'];
                $productId = (int)$item['product_id'];

                $stockStmt->bind_param(
                    'ii',
                    $quantity,
                    $productId
                );
                $stockStmt->execute();

                if ($stockStmt->affected_rows !== 1) {
                    throw new RuntimeException(
                        'Could not release reserved product stock.'
                    );
                }
            }

            $stockStmt->close();
            $itemStmt->close();

            if ($statusCode === '-1') {
                $stmt = $conn->prepare(
                    "UPDATE orders
                     SET payment_status = 'Cancelled',
                         status = 'Cancelled',
                         payment_reference = ?
                     WHERE order_id = ?"
                );
            } else {
                $stmt = $conn->prepare(
                    "UPDATE orders
                     SET payment_status = 'Failed',
                         status = 'Cancelled',
                         payment_reference = ?
                     WHERE order_id = ?"
                );
            }

            $stmt->bind_param('si', $paymentId, $orderId);
            $stmt->execute();
            $stmt->close();

        } else {
            notifyLog(
                'Failure/cancellation notification ignored for non-pending order '
                . $orderId
            );
        }

    } elseif ($statusCode === '-3') {
        /*
         * A chargeback is not the same as an unpaid order.
         * Do not automatically restock goods that may already be shipped.
         */
        $stmt = $conn->prepare(
            "UPDATE orders
             SET payment_status = 'Chargedback',
                 status = 'Payment Review',
                 payment_reference = ?
             WHERE order_id = ?"
        );
        $stmt->bind_param('si', $paymentId, $orderId);
        $stmt->execute();
        $stmt->close();

    } else {
        notifyLog('Unhandled status code: ' . $statusCode);
    }

    $conn->commit();

    http_response_code(200);
    echo 'OK';

} catch (Throwable $e) {
    try {
        $conn->rollback();
    } catch (Throwable $ignored) {
        // Ignore rollback errors.
    }

    notifyLog(
        'Notification processing error for order '
        . $orderId . ': ' . $e->getMessage()
    );

    http_response_code(500);
    echo 'Notification processing failed';
}
