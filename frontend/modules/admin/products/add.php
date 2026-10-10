<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_admin();

$error = '';
$success = '';

$name = '';
$category = '';
$price = '';
$stock_qty = '';
$weight = '';
$description = '';
$image_url = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price = $_POST['price'] ?? '';
    $stock_qty = $_POST['stock_qty'] ?? '';
    $weight = trim($_POST['weight'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image_url = trim($_POST['image_url'] ?? '');

    if (
        $name === '' ||
        $category === '' ||
        $price === '' ||
        $stock_qty === '' ||
        !is_numeric($price) ||
        !is_numeric($stock_qty) ||
        (float)$price < 0 ||
        (int)$stock_qty < 0 ||
        (string)(int)$stock_qty !== (string)$stock_qty
    ) {
        $error = 'Please enter valid product details, price and stock quantity.';
    } else {
        $price = (float)$price;
        $stock_qty = (int)$stock_qty;

        $stmt = $conn->prepare(
            "INSERT INTO products
            (name, category, price, stock_qty, weight, description, image_url, is_active)
            VALUES (?, ?, ?, ?, ?, ?, ?, 1)"
        );

        if (!$stmt) {
            $error = 'Could not prepare the product query.';
        } else {
            $stmt->bind_param(
                'ssdisss',
                $name,
                $category,
                $price,
                $stock_qty,
                $weight,
                $description,
                $image_url
            );

            if ($stmt->execute()) {
                header('Location: index.php?added=1');
                exit;
            }

            $error = 'Product could not be added. Please check your database columns.';
            $stmt->close();
        }
    }
}

admin_header('Add Product', 'products');
?>

<div class="panel">
    <h2>Add New Product</h2>
    <p>Enter the details of your Ceylon tea product.</p>

    <?php if ($error !== ''): ?>
        <div class="alert alert-error"><?= h($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label for="name">Product Name *</label>
            <input
                type="text"
                id="name"
                name="name"
                maxlength="255"
                value="<?= h($name) ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="category">Category *</label>
            <select id="category" name="category" required>
                <option value="">Select category</option>
                <option value="CAT-BLACK" <?= $category === 'CAT-BLACK' ? 'selected' : '' ?>>Black Tea</option>
                <option value="CAT-GREEN" <?= $category === 'CAT-GREEN' ? 'selected' : '' ?>>Green Tea</option>
                <option value="CAT-TEABAGS" <?= $category === 'CAT-TEABAGS' ? 'selected' : '' ?>>Tea Bags</option>
                <option value="CAT-GIFT" <?= $category === 'CAT-GIFT' ? 'selected' : '' ?>>Gift Boxes</option>
            </select>
        </div>

        <div class="form-group">
            <label for="price">Price (Rs.) *</label>
            <input
                type="number"
                id="price"
                name="price"
                min="0"
                step="0.01"
                value="<?= h($price) ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="stock_qty">Stock Quantity *</label>
            <input
                type="number"
                id="stock_qty"
                name="stock_qty"
                min="0"
                step="1"
                value="<?= h($stock_qty) ?>"
                required
            >
        </div>

        <div class="form-group">
            <label for="weight">Weight</label>
            <input
                type="text"
                id="weight"
                name="weight"
                placeholder="e.g. 250g"
                value="<?= h($weight) ?>"
            >
        </div>

        <div class="form-group">
            <label for="image_url">Image URL or Path</label>
            <input
                type="text"
                id="image_url"
                name="image_url"
                placeholder="e.g. assets/images/black-tea.jpg"
                value="<?= h($image_url) ?>"
            >
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea
                id="description"
                name="description"
                rows="5"
            ><?= h($description) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Product</button>
        <a href="index.php" class="btn" style="background:#e5e7eb;">Cancel</a>
    </form>
</div>

<?php admin_footer(); ?>