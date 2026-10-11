
<?php
require_once __DIR__ . '/../config/db_connection.php';
require_once __DIR__ . '/../config/session.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['success' => false, 'message' => 'Invalid request.'], 405);
}

$input = json_decode(file_get_contents('php://input'), true);

if (!is_array($input)) {
    json_response(['success' => false, 'message' => 'Invalid form data.'], 400);
}

$firstName = trim($input['firstName'] ?? '');
$lastName = trim($input['lastName'] ?? '');
$email = strtolower(trim($input['email'] ?? ''));
$password = $input['password'] ?? '';

$fullName = trim($firstName . ' ' . $lastName);

if ($firstName === '' || $lastName === '') {
    json_response(['success' => false, 'message' => 'Please enter your first and last name.'], 422);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
    json_response(['success' => false, 'message' => 'Please enter a valid email address.'], 422);
}

if (!is_string($password) || strlen($password) < 8 || strlen($password) > 72) {
    json_response(['success' => false, 'message' => 'Password must be at least 8 characters.'], 422);
}

try {
    $check = $conn->prepare('SELECT user_id FROM users WHERE email = ? LIMIT 1');
    $check->bind_param('s', $email);
    $check->execute();

    if ($check->get_result()->num_rows > 0) {
        json_response(['success' => false, 'message' => 'This email is already registered.'], 409);
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $role = 'customer';

    $stmt = $conn->prepare(
        'INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, ?)'
    );
    $stmt->bind_param('ssss', $fullName, $email, $hash, $role);
    $stmt->execute();

    json_response([
        'success' => true,
        'message' => 'Registration successful. You can now log in.'
    ], 201);

} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    json_response(['success' => false, 'message' => 'Registration failed. Please try again.'], 500);
}
