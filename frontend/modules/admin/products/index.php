
<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_admin();

$search = trim($_GET['search'] ?? '');
$error = '';
$products = [];

$successMessages = [
    'added' => 'Product added successfully!',
    'updated' => 'Product updated successfully!',
    'deleted' => 'Product deleted successfully!',
    'status' => 'Product status updated successfully!'
];

$success = $successMessages[$_GET['success'] ?? ''] ?? '';

$sql = "SELECT product_id, name, price, stock_qty, category, is_active
        FROM products";

if ($search !== '') {
    $sql .= " WHERE name LIKE ? OR category LIKE ?";
}

$sql .= " ORDER BY product_id DESC";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    $error = 'Unable to load products. Please check your database.';
} else {
    if ($search !== '') {
        $term = '%' . $search . '%';
        $stmt->bind_param('ss', $term, $term);
    }

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    } else {
        $error = 'Unable to retrieve products.';
    }

    $stmt->close();
}

admin_header('Products', 'products');
?>

<div class="panel">
    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:15px;">
        <div>
            <h2>Product Management</h2>
            <p>Manage your Ceylon Tea House products.</p>
        </div>

        <a href="add.php" class="btn btn-primary">+ Add Product</a>
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

    <form method="get" style="display:flex; gap:10px; margin:25px 0; flex-wrap:wrap;">
        <input
            type="search"
            name="search"
            placeholder="Search product or category..."
            value="<?= h($search) ?>"
            style="flex:1; min-width:180px; padding:12px; border:1px solid #d5dbd6; border-radius:7px;"
        >

        <button class="btn btn-primary" type="submit">Search</button>

        <a href="index.php" class="btn" style="background:#e5e7eb;">Reset</a>
    </form>

    <p style="margin-bottom:15px; color:#657167;">
        Products found: <strong><?= count($products) ?></strong>
    </p>

    <div style="overflow-x:auto;">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= h($product['product_id']) ?></td>
                        <td><strong><?= h($product['name']) ?></strong></td>
                        <td><?= h($product['category'] ?? '—') ?></td>
                        <td>Rs. <?= number_format((float)$product['price'], 2) ?></td>
                        <td><?= h($product['stock_qty']) ?></td>

                        <td>
                            <?php if ((int)$product['is_active'] === 1): ?>
                                <span style="color:#15803d;font-weight:bold;">Active</span>
                            <?php else: ?>
                                <span style="color:#b42318;font-weight:bold;">Inactive</span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                <a
                                    href="edit.php?id=<?= (int)$product['product_id'] ?>"
                                    class="btn btn-primary"
                                >Edit</a>

                                <form method="post" action="delete.php"
                                      onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    <input type="hidden" name="product_id"
                                           value="<?= (int)$product['product_id'] ?>">

                                    <button type="submit" class="btn"
                                            style="background:#fee2e2;color:#b42318;">
                                        Delete
                                    </button>
                                </form>

                                <form method="post" action="toggle-status.php">
                                    <input type="hidden" name="product_id"
                                           value="<?= (int)$product['product_id'] ?>">

                                    <button type="submit" class="btn"
                                            style="background:#e5e7eb;">
                                        <?= (int)$product['is_active'] === 1 ? 'Deactivate' : 'Activate' ?>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;padding:25px;">
                        <?= $search !== ''
                            ? 'No matching products found.'
                            : 'No products available yet. Click + Add Product to get started.' ?>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php admin_footer(); ?>
