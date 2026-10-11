
<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_admin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header('Location: index.php');
    exit;
}

$stmt = $conn->prepare(
    "UPDATE products
     SET is_active = IF(is_active = 1, 0, 1)
     WHERE product_id = ?"
);

$stmt->bind_param('i', $id);

if ($stmt->execute() && $stmt->affected_rows > 0) {
    $stmt->close();
    header('Location: index.php?success=status');
    exit;
}

$stmt->close();
header('Location: index.php');
exit;
