<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/db_connection.php';
require_once __DIR__ . '/../config/session.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response([
        'success' => false,
        'message' => 'Invalid request method.'
    ], 405);
}

$userId = require_customer();

$input = json_decode(
    file_get_contents('php://input'),
    true
);

$orderId = filter_var(
    $input['order_id'] ?? null,
    FILTER_VALIDATE_INT
);

if (!$orderId || $orderId < 1) {
    json_response([
        'success' => false,
        'message' => 'Invalid order ID.'
    ], 400);
}

$method = 'card';

$stmt = $conn->prepare(
    'SELECT payment_status
     FROM orders
     WHERE order_id = ?
       AND user_id = ?
       AND payment_method = ?
     LIMIT 1'
);

$stmt->bind_param('iis', $orderId, $userId, $method);

$stmt->execute();

$order = $stmt->get_result()->fetch_assoc();

$stmt->close();

if (!$order) {
    json_response([
        'success' => false,
        'message' => 'Order not found.'
    ], 404);
}

$isPaid = strtolower(
    (string) $order['payment_status']
) === 'paid';

json_response([
    'success' => true,
    'paid' => $isPaid,
    'payment_status' => $order['payment_status']
]);