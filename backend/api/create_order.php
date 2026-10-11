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

$input = json_decode(file_get_contents('php://input'), true);

if (!is_array($input)) {
    json_response([
        'success' => false,
        'message' => 'Invalid JSON request.'
    ], 400);
}

$firstName = trim($input['first_name'] ?? '');
$lastName  = trim($input['last_name'] ?? '');
$email     = trim($input['email'] ?? '');
$phone     = trim($input['phone'] ?? '');
$address   = trim($input['address'] ?? '');
$city      = trim($input['city'] ?? '');
$district  = trim($input['district'] ?? '');
$notes     = trim($input['notes'] ?? '');
$method    = strtolower(trim($input['payment_method'] ?? ''));
$items     = $input['items'] ?? [];

if (
    $firstName === '' ||
    $lastName === '' ||
    !filter_var($email, FILTER_VALIDATE_EMAIL) ||
    $phone === '' ||
    $address === '' ||
    $city === '' ||
    $district === ''
) {
    json_response([
        'success' => false,
        'message' => 'Please provide all required customer and delivery details.'
    ], 400);
}

if (!in_array($method, ['cash', 'card'], true)) {
    json_response([
        'success' => false,
        'message' => 'Invalid payment method.'
    ], 400);
}

if (!is_array($items) || count($items) === 0) {
    json_response([
        'success' => false,
        'message' => 'Your cart is empty.'
    ], 400);
}

$customerName = trim($firstName . ' ' . $lastName);
$subtotal = 0;
$preparedItems = [];

try {
    $conn->begin_transaction();

    /*
     * Get the real product prices and stock from the database.
     * Do not trust prices sent by the browser.
     */
    foreach ($items as $item) {
        $productId = filter_var(
            $item['product_id'] ?? $item['id'] ?? null,
            FILTER_VALIDATE_INT
        );

        $productName = trim($item['name'] ?? '');
        $quantity = filter_var(
            $item['quantity'] ?? null,
            FILTER_VALIDATE_INT
        );

        if ($quantity === false || $quantity < 1 || $quantity > 100) {
            throw new Exception('A cart item has an invalid quantity.');
        }

        if ($productId !== false && $productId !== null && $productId > 0) {
            $stmt = $conn->prepare(
                'SELECT product_id, name, price, stock_qty, is_active
                 FROM products
                 WHERE product_id = ?
                 LIMIT 1'
            );
            $stmt->bind_param('i', $productId);
        } elseif ($productName !== '') {
            /*
             * The current cart may contain a product name but no product_id.
             * In that case, resolve the exact name from the database.
             */
            $stmt = $conn->prepare(
                'SELECT product_id, name, price, stock_qty, is_active
                 FROM products
                 WHERE name = ?
                 LIMIT 2'
            );
            $stmt->bind_param('s', $productName);
        } else {
            throw new Exception('A cart item is missing its product information.');
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();

        if (!$product) {
            $stmt->close();
            throw new Exception('A product in your cart could not be found.');
        }

        if ($productName !== '' && $productName !== $product['name']) {
            $stmt->close();
            throw new Exception('The product information in your cart has changed.');
        }

        // Exact-name lookup must not select an ambiguous product.
        if (
            !isset($productId) ||
            $productId === false ||
            $productId === null ||
            $productId <= 0
        ) {
            if ($result->num_rows > 1) {
                $stmt->close();
                throw new Exception(
                    'A product name matches more than one database record.'
                );
            }
        }

        $stmt->close();

        if ((int)$product['is_active'] !== 1) {
            throw new Exception($product['name'] . ' is currently unavailable.');
        }

        if ((int)$product['stock_qty'] < $quantity) {
            throw new Exception(
                'Not enough stock available for ' . $product['name'] . '.'
            );
        }

        $unitPrice = (float)$product['price'];
        $subtotal += $unitPrice * $quantity;

        $preparedItems[] = [
            'product_id' => (int)$product['product_id'],
            'quantity' => $quantity,
            'unit_price' => $unitPrice
        ];
    }

    // Match the shipping rule currently used on the checkout page.
    $shippingCost = ($subtotal > 0 && $subtotal < 5000) ? 350 : 0;
    $totalAmount = $subtotal + $shippingCost;

    $paymentStatus = 'Pending';
    $orderStatus = 'Pending';

    $stmt = $conn->prepare(
        'INSERT INTO orders (
            user_id,
            total_amount,
            status,
            payment_method,
            payment_status,
            customer_name,
            customer_email,
            customer_phone,
            shipping_address,
            shipping_city,
            shipping_district,
            order_notes,
            shipping_cost
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );

    $stmt->bind_param(
        'idssssssssssd',
        $userId,
        $totalAmount,
        $orderStatus,
        $method,
        $paymentStatus,
        $customerName,
        $email,
        $phone,
        $address,
        $city,
        $district,
        $notes,
        $shippingCost
    );

    if (!$stmt->execute()) {
        throw new Exception('Could not create the order.');
    }

    $orderId = (int)$conn->insert_id;
    $stmt->close();

    $itemStmt = $conn->prepare(
        'INSERT INTO order_items (
            order_id,
            product_id,
            quantity,
            unit_price
        ) VALUES (?, ?, ?, ?)'
    );

    foreach ($preparedItems as $preparedItem) {
        $productId = $preparedItem['product_id'];
        $quantity = $preparedItem['quantity'];
        $unitPrice = $preparedItem['unit_price'];

        $itemStmt->bind_param(
            'iiid',
            $orderId,
            $productId,
            $quantity,
            $unitPrice
        );

        if (!$itemStmt->execute()) {
            throw new Exception('Could not save the order items.');
        }
    }

    $itemStmt->close();
    $conn->commit();

    json_response([
        'success' => true,
        'message' => 'Order saved successfully.',
        'order_id' => $orderId,
        'subtotal' => round($subtotal, 2),
        'shipping_cost' => round($shippingCost, 2),
        'total_amount' => round($totalAmount, 2),
        'payment_method' => $method,
        'payment_status' => $paymentStatus
    ]);

} catch (Throwable $e) {
    try {
        $conn->rollback();
    } catch (Throwable $ignored) {
        // Nothing else to roll back.
    }

    error_log('Create order error: ' . $e->getMessage());

    json_response([
        'success' => false,
        'message' => $e instanceof Exception
            ? $e->getMessage()
            : 'An error occurred while saving your order.'
    ], 400);
}