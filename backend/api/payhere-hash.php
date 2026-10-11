
<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/db_connection.php';

function jsonResponse(int $status, array $data): void
{
    http_response_code($status);
    echo json_encode($data);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(405, [
        'success' => false,
        'message' => 'POST method required.'
    ]);
}

if (empty($_SESSION['user_id'])) {
    jsonResponse(401, [
        'success' => false,
        'message' => 'Please log in before paying.'
    ]);
}

$config = require __DIR__ . '/../config/payhere_config.php';

$merchantId = trim((string)($config['merchant_id'] ?? ''));
$merchantSecret = trim((string)($config['merchant_secret'] ?? ''));
$notifyUrl = trim((string)($config['notify_url'] ?? ''));

$scheme = strtolower((string)parse_url($notifyUrl, PHP_URL_SCHEME));
$host = strtolower((string)parse_url($notifyUrl, PHP_URL_HOST));

if (
    $merchantId === '' ||
    $merchantSecret === '' ||
    $merchantSecret === 'PASTE_NEW_MERCHANT_SECRET_HERE' ||
    !filter_var($notifyUrl, FILTER_VALIDATE_URL) ||
    $scheme !== 'https' ||
    in_array($host, ['localhost', '127.0.0.1'], true) ||
    str_contains($host, 'YOUR-PUBLIC-HTTPS-DOMAIN')
) {
    jsonResponse(500, [
        'success' => false,
        'message' => 'PayHere configuration is incomplete. Set your Merchant Secret and public HTTPS notification URL.'
    ]);
}

$input = json_decode(file_get_contents('php://input'), true);

if (!is_array($input)) {
    jsonResponse(400, [
        'success' => false,
        'message' => 'Invalid JSON request.'
    ]);
}

$orderId = filter_var($input['order_id'] ?? null, FILTER_VALIDATE_INT);
$amountInput = $input['amount'] ?? null;

if (
    !$orderId ||
    !is_numeric($amountInput) ||
    !is_finite((float)$amountInput) ||
    (float)$amountInput <= 0
) {
    jsonResponse(400, [
        'success' => false,
        'message' => 'Invalid order ID or amount.'
    ]);
}

try {
    $userId = (int)$_SESSION['user_id'];

    $stmt = $conn->prepare(
        "SELECT total_amount, payment_method, payment_status
         FROM orders
         WHERE order_id = ? AND user_id = ?
         LIMIT 1"
    );

    if (!$stmt) {
        throw new RuntimeException('Failed to prepare order query.');
    }

    $stmt->bind_param('ii', $orderId, $userId);
    $stmt->execute();
    $order = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$order) {
        jsonResponse(404, [
            'success' => false,
            'message' => 'Order not found.'
        ]);
    }

    if (strtolower((string)$order['payment_method']) !== 'card') {
        jsonResponse(400, [
            'success' => false,
            'message' => 'This is not a card payment order.'
        ]);
    }

    if (strtolower((string)$order['payment_status']) === 'paid') {
        jsonResponse(409, [
            'success' => false,
            'message' => 'This order is already paid.'
        ]);
    }

    $savedAmount = number_format((float)$order['total_amount'], 2, '.', '');
    $requestedAmount = number_format((float)$amountInput, 2, '.', '');

    if ($savedAmount !== $requestedAmount) {
        jsonResponse(400, [
            'success' => false,
            'message' => 'Payment amount does not match the order.'
        ]);
    }

    $currency = 'LKR';
    $hashedSecret = strtoupper(md5($merchantSecret));

    $hash = strtoupper(md5(
        $merchantId .
        (string)$orderId .
        $savedAmount .
        $currency .
        $hashedSecret
    ));

    jsonResponse(200, [
        'success' => true,
        'merchant_id' => $merchantId,
        'order_id' => (string)$orderId,
        'amount' => $savedAmount,
        'currency' => $currency,
        'hash' => $hash,
        'notify_url' => $notifyUrl
    ]);

} catch (Throwable $e) {
    error_log('PayHere hash error: ' . $e->getMessage());

    jsonResponse(500, [
        'success' => false,
        'message' => 'Unable to prepare payment. Check the PHP error log.'
    ]);
}
