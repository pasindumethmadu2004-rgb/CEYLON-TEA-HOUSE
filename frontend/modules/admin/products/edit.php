
<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_admin();

$error = '';
$product = null;

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare(
    "SELECT product_id, name, category, price, stock_qty,
            weight, description, image_url, is_active
     FROM products WHERE product_id = ?"
);

$stmt->bind_param('i', $id);
$stmt->execute();

$result = $stmt->get_result();
$product = $result->fetch_assoc();
$stmt->close();

if (!$product) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $price = filter_var($_POST['price'] ?? '', FILTER_VALIDATE_FLOAT);
    $stock = filter_var($_POST['stock_qty'] ?? '', FILTER_VALIDATE_INT);
    $weight = trim($_POST['weight'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $image = trim($_POST['image_url'] ?? '');
    $active = isset($_POST['is_active']) ? 1 : 0;

    if ($name === '' || $category === '' ||
        $price === false || $price < 0 ||
        $stock === false || $stock < 0) {
        $error = 'Please enter valid product details.';
    } else {
        $stmt = $conn->prepare(
            "UPDATE products
             SET name=?, category=?, price=?, stock_qty=?,
                 weight=?, description=?, image_url=?, is_active=?
             WHERE product_id=?"
        );

        $stmt->bind_param(
            'ssdisssii',
            $name, $category, $price, $stock,
            $weight, $description, $image, $active, $id
        );

        if ($stmt->execute()) {
            $stmt->close();
            header('Location: index.php?success=updated');
            exit;
        }

        $error = 'Unable to update product. Please check the database columns.';
        $stmt->close();

        $product = array_merge($product, [
            'name' => $name,
            'category' => $category,
            'price' => $price,
            'stock_qty' => $stock,
            'weight' => $weight,
            'description' => $description,
            'image_url' => $image,
            'is_active' => $active
        ]);
    }
}

admin_header('Edit Product', 'products');
?>

<div class="panel">
    <h2>Edit Product</h2>
    <p>Update the product details below.</p>

    <?php if ($error !== ''): ?>
        <div class="alert alert-error" style="margin:15px 0;">
            <?= h($error) ?>
        </div>
    <?php endif; ?>

    <form method="post" style="max-width:700px;margin-top:25px;">

        <label>Product Name</label>
        <input name="name" required
               value="<?= h($product['name']) ?>"
               style="width:100%;padding:10px;margin:8px 0 18px;">

        <label>Category</label>
        <input name="category" required
               value="<?= h($product['category'] ?? '') ?>"
               style="width:100%;padding:10px;margin:8px 0 18px;">

        <label>Price (Rs.)</label>
        <input type="number" name="price" min="0" step="0.01" required
               value="<?= h($product['price']) ?>"
               style="width:100%;padding:10px;margin:8px 0 18px;">

        <label>Stock Quantity</label>
        <input type="number" name="stock_qty" min="0" required
               value="<?= h($product['stock_qty']) ?>"
               style="width:100%;padding:10px;margin:8px 0 18px;">

        <label>Weight</label>
        <input name="weight"
               value="<?= h($product['weight'] ?? '') ?>"
               style="width:100%;padding:10px;margin:8px 0 18px;">

        <label>Description</label>
        <textarea name="description" rows="4"
                  style="width:100%;padding:10px;margin:8px 0 18px;"><?= h($product['description'] ?? '') ?></textarea>

        <label>Image URL</label>
        <input name="image_url"
               value="<?= h($product['image_url'] ?? '') ?>"
               style="width:100%;padding:10px;margin:8px 0 18px;">

        <label style="display:block;margin-bottom:20px;">
            <input type="checkbox" name="is_active" value="1"
                <?= (int)$product['is_active'] === 1 ? 'checked' : '' ?>>
            Product is active
        </label>

        <button type="submit" class="btn btn-primary">
            Save Changes
        </button>

        <a href="index.php" class="btn" style="background:#e5e7eb;">
            Cancel
        </a>
    </form>
</div>

<?php admin_footer(); ?>
