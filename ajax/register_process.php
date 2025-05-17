<?php
header('Content-Type: application/json');
require_once '../includes/db.php';
require_once '../includes/email.php';

$response = ['status' => 'error', 'message' => 'Something went wrong.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role = trim($_POST['role'] ?? 'user');

    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        $response['message'] = 'Please fill in all required fields.';
        echo json_encode($response);
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if user already exists
    $checkQuery = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $checkQuery->bind_param('s', $email);
    $checkQuery->execute();
    $checkQuery->store_result();

    if ($checkQuery->num_rows > 0) {
        $response['message'] = 'Email already registered.';
        echo json_encode($response);
        exit;
    }

    // Insert new user with "pending" status
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param('ssss', $username, $email, $hashedPassword, $role);

    if ($stmt->execute()) {
        // Send email notification to Chief Officer
        $subject = "New User Registration on Laikipia System";
        $body = "
            <p>Hello Chief Officer,</p>
            <p>A new user has registered in the Laikipia system with the following details:</p>
            <ul>
                <li><strong>Username:</strong> {$username}</li>
                <li><strong>Email:</strong> {$email}</li>
                <li><strong>Role:</strong> {$role}</li>
            </ul>
            <p>Please log in to review and approve this account.</p>
        ";

        notifyChiefOfficer($subject, $body);

        $response['status'] = 'success';
        $response['message'] = 'Registration successful. Awaiting approval.';
    } else {
        $response['message'] = 'Failed to register user.';
    }

    $stmt->close();
    $checkQuery->close();
    $conn->close();
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
