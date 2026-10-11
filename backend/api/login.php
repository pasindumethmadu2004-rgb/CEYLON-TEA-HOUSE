
<?php
require_once __DIR__ . '/../config/db_connection.php';
require_once __DIR__ . '/../config/session.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response([
        'success' => false,
        'message' => 'Invalid request.'
    ], 405);
}

$input = json_decode(file_get_contents('php://input'), true);

if (!is_array($input)) {
    json_response([
        'success' => false,
        'message' => 'Invalid form data.'
    ], 400);
}

$email = strtolower(trim($input['email'] ?? ''));
$password = $input['password'] ?? '';

if ($email === '' || !is_string($password) || $password === '') {
    json_response([
        'success' => false,
        'message' => 'Please enter your email and password.'
    ], 422);
}

try {
    $stmt = $conn->prepare(
        "SELECT user_id, full_name, email, password_hash, role
         FROM users
         WHERE email = ?
         LIMIT 1"
    );

    $stmt->bind_param('s', $email);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();

    if (
        !$user ||
        !password_verify($password, $user['password_hash']) ||
        $user['role'] !== 'customer'
    ) {
        json_response([
            'success' => false,
            'message' => 'Invalid email or password.'
        ], 401);
    }

    session_regenerate_id(true);

    $_SESSION['user_id'] = (int) $user['user_id'];
    $_SESSION['user_name'] = $user['full_name'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['role'] = 'customer';

    json_response([
        'success' => true,
        'message' => 'Login successful.',
        'user' => [
            'name' => $user['full_name'],
            'email' => $user['email']
        ]
    ]);

} catch (Throwable $e) {
    error_log('Customer login error: ' . $e->getMessage());

    json_response([
        'success' => false,
        'message' => 'Login failed. Please try again.'
    ], 500);
}
