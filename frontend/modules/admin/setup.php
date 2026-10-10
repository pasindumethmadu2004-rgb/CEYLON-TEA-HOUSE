<?php
require_once __DIR__ . '/includes/bootstrap.php';

$message = '';
$error = '';

if ((int)$conn->query("SELECT COUNT(*) AS total FROM admins")->fetch_assoc()['total'] > 0) {
    $message = 'An admin account already exists. Please use the login page.';
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 12) {
        $error = 'Enter a valid name and email. Password must have at least 12 characters.';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO admins (name, email, password_hash) VALUES (?, ?, ?)"
        );
        $stmt->bind_param('sss', $name, $email, $hash);

        if ($stmt->execute()) {
            $message = 'Admin account created. You can now log in.';
        } else {
            $error = 'Could not create the admin account. Check the email and try again.';
        }

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Admin | Ceylon Tea House</title>
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>
<div class="login-page">
    <section class="login-visual">
        <h1>🍃 Ceylon Tea House</h1>
        <p>Create your store administrator account.</p>
    </section>

    <section class="login-form-side">
        <div class="login-card">
            <h2>Create Admin</h2>
            <p>Set up the first administrator account.</p>

            <?php if ($message): ?>
                <div class="alert alert-success">
                    <?= h($message) ?>
                    <p><a href="login.php">Go to login</a></p>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-error"><?= h($error) ?></div>
            <?php endif; ?>

            <?php if (!$message || (int)$conn->query("SELECT COUNT(*) AS total FROM admins")->fetch_assoc()['total'] === 0): ?>
            <form method="post">
                <div class="form-group">
                    <label for="name">Full name</label>
                    <input id="name" name="name" required maxlength="100">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password (minimum 12 characters)</label>
                    <input id="password" type="password" name="password" minlength="12" required>
                </div>

                <button class="btn btn-primary" type="submit">Create Admin Account</button>
            </form>
            <?php endif; ?>
        </div>
    </section>
</div>
</body>
</html>