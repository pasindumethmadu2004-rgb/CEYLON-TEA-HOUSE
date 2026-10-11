
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

if (!is_array($items) || count($items) === 0 || count($items) > 100) {
    json_response([
        'success' => false,
        'message' => 'Your cart is empty or contains too many items.'
    ], 400);
}

$customerName = trim($firstName . ' ' . $lastName);
$preparedItems = [];
$subtotal = 0.0;
$transactionStarted = false;

try {
    $conn->begin_transaction();
    $transactionStarted = true;

    /*
     * Resolve products using the database.
     * Lock product records while checking and reserving stock.
     */
    foreach ($items as $item) {
        if (!is_array($item)) {
            throw new RuntimeException('Invalid cart item.');
        }

        $quantity = filter_var(
            $item['quantity'] ?? null,
            FILTER_VALIDATE_INT
        );

        if ($quantity === false || $quantity < 1 || $quantity > 100) {
            throw new RuntimeException('A cart item has an invalid quantity.');
        }

        $rawProductId = $item['product_id'] ?? $item['id'] ?? null;
        $productId = filter_var($rawProductId, FILTER_VALIDATE_INT);
        $productName = trim((string)($item['name'] ?? $item['product_name'] ?? ''));

        if ($productId !== false && $productId !== null && $productId > 0) {
            $stmt = $conn->prepare(
                'SELECT product_id, name, price, stock_qty, is_active
                 FROM products
                 WHERE product_id = ?
                 FOR UPDATE'
            );
            $stmt->bind_param('i', $productId);
        } elseif ($productName !== '') {
            $stmt = $conn->prepare(
                'SELECT product_id, name, price, stock_qty, is_active
                 FROM products
                 WHERE name = ?
                 LIMIT 2'
            );
            $stmt->bind_param('s', $productName);
        } else {
            throw new RuntimeException(
                'A cart item is missing its product information.'
            );
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $matchCount = $result->num_rows;
        $stmt->close();

        if (!$product) {
            throw new RuntimeException(
                'A product in your cart could not be found.'
            );
        }

        if (
            ($productId === false || $productId === null || $productId <= 0)
            && $matchCount > 1
        ) {
            throw new RuntimeException(
                'A product name matches more than one database record. Please refresh your cart.'
            );
        }

        if (
            $productName !== '' &&
            $productName !== $product['name']
        ) {
            throw new RuntimeException(
                'The product information in your cart has changed. Please refresh your cart.'
            );
        }

        if ((int)$product['is_active'] !== 1) {
            throw new RuntimeException(
                $product['name'] . ' is currently unavailable.'
            );
        }

        $id = (int)$product['product_id'];

        /*
         * Combine repeated occurrences of the same product.
         * Stock must be checked against the combined quantity.
         */
        if (isset($preparedItems[$id])) {
            $preparedItems[$id]['quantity'] += $quantity;
        } else {
            $preparedItems[$id] = [
                'product_id' => $id,
                'name' => $product['name'],
                'quantity' => $quantity,
                'unit_price' => (float)$product['price'],
                'stock_qty' => (int)$product['stock_qty']
            ];
        }

        if ($preparedItems[$id]['quantity'] > 100) {
            throw new RuntimeException(
                'The total quantity for one product cannot exceed 100.'
            );
        }
    }

    /*
     * Validate combined quantities and calculate totals
     * using prices from the database.
     */
    foreach ($preparedItems as $product) {
        if ($product['stock_qty'] < $product['quantity']) {
            throw new RuntimeException(
                'Not enough stock available for ' . $product['name'] . '.'
            );
        }

        $subtotal += $product['unit_price'] * $product['quantity'];
    }

    $shippingCost = ($subtotal > 0 && $subtotal < 5000) ? 350.00 : 0.00;
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

    $stmt->execute();
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

    $stockStmt = $conn->prepare(
        'UPDATE products
         SET stock_qty = stock_qty - ?
         WHERE product_id = ?
           AND stock_qty >= ?
           AND is_active = 1'
    );

    foreach ($preparedItems as $product) {
        $productId = $product['product_id'];
        $quantity = $product['quantity'];
        $unitPrice = $product['unit_price'];

        $itemStmt->bind_param(
            'iiid',
            $orderId,
            $productId,
            $quantity,
            $unitPrice
        );
        $itemStmt->execute();

        /*
         * Conditional update provides an additional stock safeguard.
         */
        $stockStmt->bind_param(
            'iii',
            $quantity,
            $productId,
            $quantity
        );
        $stockStmt->execute();

        if ($stockStmt->affected_rows !== 1) {
            throw new RuntimeException(
                'Stock changed while processing your order. Please try again.'
            );
        }
    }

    $itemStmt->close();
    $stockStmt->close();

    $conn->commit();
    $transactionStarted = false;

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
    if ($transactionStarted) {
        try {
            $conn->rollback();
        } catch (Throwable $ignored) {
            // Preserve the original error.
        }
    }

    error_log('Create order error: ' . $e->getMessage());

    $clientErrors = [
        'Invalid cart item.',
        'A cart item has an invalid quantity.',
        'Your cart is empty or contains too many items.',
        'A cart item is missing its product information.',
        'A product in your cart could not be found.',
        'A product name matches more than one database record. Please refresh your cart.',
        'The product information in your cart has changed. Please refresh your cart.',
        'is currently unavailable.',
        'cannot exceed 100.',
        'Not enough stock available for ',
        'Stock changed while processing your order. Please try again.'
    ];

    $message = 'Could not place your order. Please try again.';
    $errorMessage = $e->getMessage();

    foreach ($clientErrors as $knownError) {
        if (
            $errorMessage === $knownError ||
            str_contains($errorMessage, $knownError)
        ) {
            $message = $errorMessage;
            break;
        }
    }

    json_response([
        'success' => false,
        'message' => $message
    ], 400);
}
