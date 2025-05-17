<?php
require_once '../includes/db.php';

header('Content-Type: application/json');

// Utility: consistent JSON error response with HTTP code
function errorResponse($message, $code = 400) {
    http_response_code($code);
    echo json_encode(['status' => 'error', 'message' => $message]);
    exit;
}

// Utility: consistent JSON success response
function successResponse($dataOrMessage) {
    http_response_code(200);
    echo is_array($dataOrMessage)
        ? json_encode(['status' => 'success', 'data' => $dataOrMessage])
        : json_encode(['status' => 'success', 'message' => $dataOrMessage]);
    exit;
}

// === CASE 1: Fetch user by ID ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_user_id'])) {
    $userId = intval($_POST['edit_user_id']);

    if (!$userId) {
        errorResponse('Invalid user ID.');
    }

    $stmt = $conn->prepare("SELECT id, username, email, role, status FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        successResponse($user);
    } else {
        errorResponse('User not found.');
    }
}

// === CASE 2: Update user details ===
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_user_id'])) {
    $userId = intval($_POST['update_user_id']);
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = trim($_POST['role'] ?? '');
    $status = trim($_POST['status'] ?? '');

    if (!$userId || !$username || !$email || !$role || !$status) {
        errorResponse('All fields are required.');
    }

    $stmt = $conn->prepare("
        UPDATE users 
        SET username = ?, email = ?, role = ?, status = ?, updated_at = NOW() 
        WHERE id = ?
    ");
    $stmt->bind_param("ssssi", $username, $email, $role, $status, $userId);

    if ($stmt->execute()) {
        successResponse('User updated successfully.');
    } else {
        errorResponse('Failed to update user.', 500);
    }
}

// === FALLBACK: No recognized action ===
errorResponse('Invalid request.', 400);
