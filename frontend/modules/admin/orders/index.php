
<?php

require_once __DIR__ . '/../includes/bootstrap.php';
require_admin();

$search = trim($_GET['search'] ?? '');
$status = trim($_GET['status'] ?? '');

$allowedStatuses = [
    'Pending',
    'Processing',
    'Shipped',
    'Delivered',
    'Cancelled'
];

$error = '';
$orders = [];

if (isset($_GET['updated']) && $_GET['updated'] === '1') {
    $success = 'Order status updated successfully!';
} else {
    $success = '';
}

$sql = "SELECT order_id, user_id, total_amount, status, created_at
        FROM orders
        WHERE 1=1";

if ($search !== '') {
    $sql .= " AND CAST(order_id AS CHAR) LIKE ?";
}

if (in_array($status, $allowedStatuses, true)) {
    $sql .= " AND status = ?";
}

$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    $error = 'Unable to prepare the orders query.';
} else {
    if ($search !== '' && in_array($status, $allowedStatuses, true)) {
        $term = '%' . $search . '%';
        $stmt->bind_param('ss', $term, $status);
    } elseif ($search !== '') {
        $term = '%' . $search . '%';
        $stmt->bind_param('s', $term);
    } elseif (in_array($status, $allowedStatuses, true)) {
        $stmt->bind_param('s', $status);
    }

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
    } else {
        $error = 'Unable to load orders.';
    }

    $stmt->close();
}

admin_header('Orders', 'orders');
?>

<div class="panel">

    <div style="display:flex;justify-content:space-between;
                align-items:center;flex-wrap:wrap;gap:15px;">
        <div>
            <h2>Orders Management</h2>
            <p>View customer orders and manage their status.</p>
        </div>
    </div>

    <?php if ($success !== ''): ?>
        <div class="alert alert-success" style="margin-top:20px;">
            <?= h($success) ?>
        </div>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <div class="alert alert-error" style="margin-top:20px;">
            <?= h($error) ?>
        </div>
    <?php endif; ?>

    <form method="get"
          style="display:flex;gap:10px;margin:25px 0;flex-wrap:wrap;">

        <input
            type="search"
            name="search"
            placeholder="Search Order ID..."
            value="<?= h($search) ?>"
            style="flex:1;min-width:170px;padding:12px;
                   border:1px solid #d5dbd6;border-radius:7px;"
        >

        <select name="status"
                style="padding:12px;border:1px solid #d5dbd6;border-radius:7px;">
            <option value="">All Statuses</option>

            <?php foreach ($allowedStatuses as $option): ?>
                <option value="<?= h($option) ?>"
                    <?= $status === $option ? 'selected' : '' ?>>
                    <?= h($option) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn btn-primary">Filter</button>

        <a href="index.php" class="btn" style="background:#e5e7eb;">
            Reset
        </a>
    </form>

    <p style="margin-bottom:15px;color:#657167;">
        Total orders found: <strong><?= count($orders) ?></strong>
    </p>

    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            <?php if (count($orders) > 0): ?>

                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>
                            #<?= h($order['order_id']) ?>
                        </td>

                        <td><?= h($order['user_id']) ?></td>

                        <td>
                            <?= h(date(
                                'd M Y',
                                strtotime($order['created_at'])
                            )) ?>
                        </td>

                        <td>
                            Rs. <?= number_format(
                                (float)$order['total_amount'], 2
                            ) ?>
                        </td>

                        <td><?= h($order['status']) ?></td>

                        <td>
                            <a class="btn btn-primary"
                               href="view.php?id=<?= (int)$order['order_id'] ?>">
                                View / Update
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            <?php else: ?>
                <tr>
                    <td colspan="6"
                        style="text-align:center;padding:25px;">
                        No orders found.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php admin_footer(); ?>
