
<?php
require_once __DIR__ . '/../config/session.php';

json_response([
    'loggedIn' => !empty($_SESSION['user_id'])
        && ($_SESSION['role'] ?? '') === 'customer'
]);
