<?php
require_once __DIR__ . '/includes/bootstrap.php';

if (!empty($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare(
        "SELECT admin_id, name, password_hash
         FROM admins
         WHERE email = ? AND is_active = 1
         LIMIT 1"
    );

    $stmt->bind_param('s', $email);
    $stmt->execute();
    $admin = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($admin && password_verify($password, $admin['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = (int)$admin['admin_id'];
        $_SESSION['admin_name'] = $admin['name'];

        header('Location: index.php');
        exit;
    }

    $error = 'Incorrect email or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | Ceylon Tea House</title>
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>
<div class="login-page">
    <section class="login-visual">
        <h1>🍃 Ceylon Tea House</h1>
        <p>Manage your tea store, products, orders and customers in one place.</p>
    </section>

    <section class="login-form-side">
        <div class="login-card">
            <h2>Admin Login</h2>
            <p>Sign in to manage your store.</p>

            <?php if ($error): ?>
                <div class="alert alert-error"><?= h($error) ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input id="email" type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                </div>

                <button class="btn btn-primary" type="submit">Sign In</button>
            </form>
        </div>
    </section>
</div>
</body>
</html>