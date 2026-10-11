
<?php
require_once __DIR__ . '/../config/db_connection.php';
require_once __DIR__ . '/../config/session.php';

$userId = require_customer();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $conn->prepare(
        "SELECT full_name, email FROM users WHERE user_id = ? LIMIT 1"
    );
    $stmt->bind_param('i', $userId);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();

    if (!$user) {
        json_response([
            'success' => false,
            'message' => 'Account not found.'
        ], 404);
    }

    json_response([
        'success' => true,
        'user' => $user
    ]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);

    if (!is_array($input)) {
        json_response([
            'success' => false,
            'message' => 'Invalid form data.'
        ], 400);
    }

    $firstName = trim($input['first_name'] ?? '');
    $lastName = trim($input['last_name'] ?? '');
    $email = strtolower(trim($input['email'] ?? ''));
    $phone = trim($input['phone'] ?? '');

    if ($firstName === '' || $lastName === '' ||
        !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        json_response([
            'success' => false,
            'message' => 'Please enter valid profile details.'
        ], 422);
    }

    $fullName = $firstName . ' ' . $lastName;

    $stmt = $conn->prepare(
        "UPDATE users SET full_name = ?, email = ? WHERE user_id = ?"
    );
    $stmt->bind_param('ssi', $fullName, $email, $userId);

    try {
        $stmt->execute();
    } catch (Throwable $e) {
        json_response([
            'success' => false,
            'message' => 'Could not update your profile. Check whether the email is already used.'
        ], 409);
    }

    $_SESSION['user_name'] = $fullName;
    $_SESSION['user_email'] = $email;

    json_response([
        'success' => true,
        'message' => 'Profile updated successfully.',
        'user' => [
            'full_name' => $fullName,
            'email' => $email
        ]
    ]);
}

json_response([
    'success' => false,
    'message' => 'Invalid request.'
], 405);
