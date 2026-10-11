<?php
require_once __DIR__ . '/../includes/bootstrap.php';

require_admin();

$order_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$order_id || $order_id < 1) {
    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare(
    "SELECT order_id, user_id, total_amount, status, created_at,
            payment_method, payment_status, customer_name,
            customer_email, customer_phone, shipping_address,
            shipping_city, shipping_district, order_notes,
            shipping_cost, payment_reference
     FROM orders
     WHERE order_id = ?"
);

$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$order) {
    header('Location: index.php');
    exit;
}

$item_stmt = $conn->prepare(
    "SELECT oi.product_id, oi.quantity, oi.unit_price,
            p.name AS product_name
     FROM order_items oi
     LEFT JOIN products p ON oi.product_id = p.product_id
     WHERE oi.order_id = ?"
);

$item_stmt->bind_param("i", $order_id);
$item_stmt->execute();
$items = $item_stmt->get_result();

admin_header('Order Details', 'orders');
?>

<style>
.order-details {
    max-width: 1100px;
    margin: 24px auto;
    color: #1e293b;
}

.order-hero {
    background: linear-gradient(135deg, #173a27, #286344);
    color: #fff;
    padding: 28px;
    border-radius: 16px;
    margin-bottom: 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    box-shadow: 0 8px 22px rgba(23, 58, 39, 0.15);
}

.order-hero h2 {
    margin: 0 0 8px;
    font-size: 26px;
}

.order-hero p {
    margin: 0;
    color: #e2eee5;
    font-size: 14px;
}

.order-status {
    display: inline-block;
    padding: 8px 15px;
    border-radius: 30px;
    background: #fff;
    color: #173a27;
    font-size: 13px;
    font-weight: 700;
}

.order-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 22px;
    margin-bottom: 22px;
}

.order-panel {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);
    min-width: 0;
}

.order-panel h3 {
    margin: 0 0 20px;
    padding-bottom: 14px;
    border-bottom: 1px solid #edf0f2;
    font-size: 18px;
    color: #173a27;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    padding: 11px 0;
    border-bottom: 1px solid #f1f5f9;
    font-size: 14px;
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    color: #64748b;
    flex-shrink: 0;
}

.detail-value {
    color: #1e293b;
    font-weight: 600;
    text-align: right;
    overflow-wrap: anywhere;
}

.order-table-wrap {
    overflow-x: auto;
    width: 100%;
}

.order-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 560px;
}

.order-table th {
    background: #f0f6f1;
    color: #234b32;
    text-align: left;
    padding: 15px;
    font-size: 13px;
    font-weight: 700;
}

.order-table td {
    padding: 15px;
    border-bottom: 1px solid #edf0f2;
    font-size: 14px;
}

.order-table tbody tr:hover {
    background: #fafcf9;
}

.product-name {
    font-weight: 600;
    color: #1e293b;
}

.product-id {
    color: #94a3b8;
    font-size: 12px;
    margin-top: 4px;
}

.order-total-panel {
    max-width: 430px;
    margin: 24px 0 0 auto;
    padding: 22px;
    background: #f8faf8;
    border: 1px solid #e1eae2;
    border-radius: 14px;
}

.total-row {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    padding: 10px 0;
    font-size: 14px;
}

.total-final {
    border-top: 1px solid #d7e2d9;
    margin-top: 8px;
    padding-top: 17px;
    font-size: 19px;
    font-weight: 800;
    color: #173a27;
}

.order-notes {
    margin-top: 22px;
    padding: 18px;
    background: #fffbeb;
    border: 1px solid #f5e7b5;
    border-radius: 12px;
    color: #854d0e;
    font-size: 14px;
    overflow-wrap: anywhere;
}

.order-actions {
    display: flex;
    justify-content: flex-start;
    margin-top: 25px;
}

.order-back-btn {
    display: inline-block;
    background: #173a27;
    color: #fff !important;
    text-decoration: none !important;
    padding: 12px 20px;
    border-radius: 9px;
    font-size: 14px;
    font-weight: 600;
    transition: background 0.2s, transform 0.2s;
}

.order-back-btn:hover {
    background: #286344;
    transform: translateY(-1px);
}

.empty-products {
    padding: 25px;
    text-align: center;
    color: #64748b;
}

@media (max-width: 700px) {
    .order-details {
        margin: 12px auto;
    }

    .order-hero {
        padding: 22px;
    }

    .order-hero h2 {
        font-size: 22px;
    }

    .order-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .order-panel {
        padding: 18px;
    }

    .detail-row {
        gap: 10px;
    }

    .order-total-panel {
        max-width: 100%;
    }
}
</style>

<div class="order-details">

    <div class="order-hero">
        <div>
            <h2>Order #<?= h($order['order_id']) ?></h2>
            <p>Placed on <?= h($order['created_at']) ?></p>
        </div>

        <span class="order-status">
            <?= h($order['status']) ?>
        </span>
    </div>

    <div class="order-grid">

        <section class="order-panel">
            <h3>Customer Details</h3>

            <div class="detail-row">
                <span class="detail-label">Customer ID</span>
                <span class="detail-value">
                    <?= h($order['user_id']) ?>
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Full Name</span>
                <span class="detail-value">
                    <?= h($order['customer_name'] ?? '') ?: '—' ?>
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Email</span>
                <span class="detail-value">
                    <?= h($order['customer_email'] ?? '') ?: '—' ?>
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Phone</span>
                <span class="detail-value">
                    <?= h($order['customer_phone'] ?? '') ?: '—' ?>
                </span>
            </div>
        </section>

        <section class="order-panel">
            <h3>Shipping Details</h3>

            <div class="detail-row">
                <span class="detail-label">Address</span>
                <span class="detail-value">
                    <?= h($order['shipping_address'] ?? '') ?: '—' ?>
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">City</span>
                <span class="detail-value">
                    <?= h($order['shipping_city'] ?? '') ?: '—' ?>
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">District</span>
                <span class="detail-value">
                    <?= h($order['shipping_district'] ?? '') ?: '—' ?>
                </span>
            </div>
        </section>

        <section class="order-panel">
            <h3>Order Information</h3>

            <div class="detail-row">
                <span class="detail-label">Order Number</span>
                <span class="detail-value">
                    #<?= h($order['order_id']) ?>
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Order Date</span>
                <span class="detail-value">
                    <?= h($order['created_at']) ?>
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Order Status</span>
                <span class="detail-value">
                    <?= h($order['status']) ?>
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Payment Method</span>
                <span class="detail-value">
                    <?= h($order['payment_method'] ?? '') ?: '—' ?>
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Payment Status</span>
                <span class="detail-value">
                    <?= h($order['payment_status'] ?? '') ?: '—' ?>
                </span>
            </div>

            <?php if (!empty($order['payment_reference'])): ?>
                <div class="detail-row">
                    <span class="detail-label">Payment Reference</span>
                    <span class="detail-value">
                        <?= h($order['payment_reference']) ?>
                    </span>
                </div>
            <?php endif; ?>
        </section>

        <section class="order-panel">
            <h3>Additional Information</h3>

            <div class="detail-row">
                <span class="detail-label">Customer ID</span>
                <span class="detail-value">
                    <?= h($order['user_id']) ?>
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Shipping Cost</span>
                <span class="detail-value">
                    Rs. <?= number_format(
                        (float) $order['shipping_cost'],
                        2
                    ) ?>
                </span>
            </div>
        </section>

    </div>

    <section class="order-panel">
        <h3>Ordered Products</h3>

        <div class="order-table-wrap">
            <table class="order-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $subtotal = 0;

                    if ($items->num_rows > 0):
                        while ($item = $items->fetch_assoc()):
                            $line_total =
                                (float) $item['unit_price']
                                * (int) $item['quantity'];

                            $subtotal += $line_total;
                    ?>
                        <tr>
                            <td>
                                <div class="product-name">
                                    <?= h(
                                        $item['product_name']
                                        ?? 'Product #' . $item['product_id']
                                    ) ?>
                                </div>

                                <div class="product-id">
                                    Product ID:
                                    <?= h($item['product_id']) ?>
                                </div>
                            </td>

                            <td><?= h($item['quantity']) ?></td>

                            <td>
                                Rs. <?= number_format(
                                    (float) $item['unit_price'],
                                    2
                                ) ?>
                            </td>

                            <td>
                                <strong>
                                    Rs. <?= number_format(
                                        $line_total,
                                        2
                                    ) ?>
                                </strong>
                            </td>
                        </tr>
                    <?php
                        endwhile;
                    else:
                    ?>
                        <tr>
                            <td colspan="4" class="empty-products">
                                No products found for this order.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="order-total-panel">

            <div class="total-row">
                <span>Items Subtotal</span>
                <span>
                    Rs. <?= number_format($subtotal, 2) ?>
                </span>
            </div>

            <div class="total-row">
                <span>Shipping Cost</span>
                <span>
                    Rs. <?= number_format(
                        (float) $order['shipping_cost'],
                        2
                    ) ?>
                </span>
            </div>

            <div class="total-row total-final">
                <span>Total Amount</span>
                <span>
                    Rs. <?= number_format(
                        (float) $order['total_amount'],
                        2
                    ) ?>
                </span>
            </div>

        </div>
    </section>

    <?php if (!empty($order['order_notes'])): ?>
        <div class="order-notes">
            <strong>Order Notes</strong>
            <p><?= nl2br(h($order['order_notes'])) ?></p>
        </div>
    <?php endif; ?>

    <div class="order-actions">
        <a href="index.php" class="order-back-btn">
            &larr; Back to Orders
        </a>
    </div>

</div>

<?php
$item_stmt->close();
admin_footer();
?>