<?php
// ajax/register/register_process.php

require_once __DIR__ . '/../../includes/db.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username   = trim($_POST['username']);
    $email      = trim($_POST['email']);
    $password   = $_POST['password'];
    $role       = $_POST['role'] ?? 'user';

    // Validate required fields
    if (empty($username) || empty($email) || empty($password)) {
        $response['message'] = 'All required fields must be filled.';
        echo json_encode($response);
        exit;
    }

    // Check if username/email already exists
    $checkQuery = "SELECT id FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $response['message'] = 'Username or email already exists.';
        echo json_encode($response);
        exit;
    }

    $stmt->close();

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Handle photo upload
    $photoPath = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../uploads/profile/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $fileTmp = $_FILES['photo']['tmp_name'];
        $fileName = time() . '_' . basename($_FILES['photo']['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmp, $targetPath)) {
            $photoPath = 'uploads/profile/' . $fileName;
        }
    }

    // Insert user
    $insertQuery = "INSERT INTO users (
        username, email, password, role, photo, status, is_disabled, failed_attempts, login_count
    ) VALUES (?, ?, ?, ?, ?, 'pending', 0, 0, 0)";

    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sssss", $username, $email, $hashedPassword, $role, $photoPath);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Registration successful!';
    } else {
        $response['message'] = 'Registration failed. Please try again.';
    }

    $stmt->close();
}

echo json_encode($response);

