<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_admin();

function get_count(mysqli $conn, string $table): int {
    $allowed = ['products', 'orders', 'users'];

    if (!in_array($table, $allowed, true)) {
        return 0;
    }

    $result = $conn->query("SELECT COUNT(*) AS total FROM `$table`");

    if (!$result) {
        return 0;
    }

    return (int)$result->fetch_assoc()['total'];
}

$products = get_count($conn, 'products');
$orders = get_count($conn, 'orders');
$customers = get_count($conn, 'users');

admin_header('Dashboard', 'dashboard');
?>

<section class="panel">
    <h2>Welcome back, <?= h($_SESSION['admin_name']) ?>!</h2>
    <p>Welcome to your Ceylon Tea House administration dashboard.</p>
</section>

<div class="dashboard-cards">
    <div class="panel">
        <p>Total Products</p>
        <h2><?= $products ?></h2>
        <a href="products/index.php">Manage products →</a>
    </div>

    <div class="panel">
        <p>Total Orders</p>
        <h2><?= $orders ?></h2>
        <a href="orders/index.php">View orders →</a>
    </div>

    <div class="panel">
        <p>Total Customers</p>
        <h2><?= $customers ?></h2>
        <a href="customers/index.php">View customers →</a>
    </div>
</div>

<style>
.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 20px;
}
.dashboard-cards .panel h2 {
    font-size: 32px;
    margin: 18px 0;
}
.dashboard-cards .panel p {
    color: #657167;
}
.dashboard-cards a {
    color: #214d35;
    font-weight: bold;
}
@media (max-width: 700px) {
    .dashboard-cards {
        grid-template-columns: 1fr;
    }
}
</style>

<?php admin_footer(); ?>