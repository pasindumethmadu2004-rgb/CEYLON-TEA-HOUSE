<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/../../../../backend/config/db_connection.php';

function h($value): string {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function require_admin(): void {
    if (empty($_SESSION['admin_id'])) {
        header('Location: login.php');
        exit;
    }
}

function admin_header(string $title, string $active = 'dashboard'): void {
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    $nested = (
        strpos($script, '/products/') !== false ||
        strpos($script, '/orders/') !== false ||
        strpos($script, '/customers/') !== false
    );

    $prefix = $nested ? '../' : '';
    $assets = $nested ? '../../../assets/' : '../../assets/';
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= h($title) ?> | Ceylon Tea House</title>
        <link rel="stylesheet" href="<?= h($assets) ?>css/admin.css">
    </head>
    <body>
    <div class="admin-shell">
        <aside class="sidebar">
            <a class="brand" href="<?= h($prefix . 'index.php') ?>">
                🍃 <span>Ceylon Tea House<small>ADMIN PANEL</small></span>
            </a>

            <p class="nav-label">MAIN MENU</p>

            <a class="side-link <?= $active === 'dashboard' ? 'active' : '' ?>"
               href="<?= h($prefix . 'index.php') ?>">⌂ Dashboard</a>

            <a class="side-link <?= $active === 'products' ? 'active' : '' ?>"
               href="<?= h($prefix . 'products/index.php') ?>">▦ Products</a>

            <a class="side-link <?= $active === 'orders' ? 'active' : '' ?>"
               href="<?= h($prefix . 'orders/index.php') ?>">▤ Orders</a>

            <a class="side-link <?= $active === 'customers' ? 'active' : '' ?>"
               href="<?= h($prefix . 'customers/index.php') ?>">♙ Customers</a>

            <div class="side-bottom">
                <a class="side-link" href="<?= h($prefix . 'logout.php') ?>">⇥ Logout</a>
            </div>
        </aside>

        <main class="main">
            <header class="topbar">
                <div>
                    <p class="crumb">CEYLON TEA HOUSE / ADMIN</p>
                    <h1><?= h($title) ?></h1>
                </div>
                <div class="admin-user">
                    <span class="avatar">
                        <?= h(strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1))) ?>
                    </span>
                    <span><?= h($_SESSION['admin_name'] ?? 'Admin') ?></span>
                </div>
            </header>
            <div class="content">
    <?php
}

function admin_footer(): void {
    ?>
            </div>
        </main>
    </div>
    </body>
    </html>
    <?php
}