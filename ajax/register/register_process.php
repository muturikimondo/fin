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

    // Handle photo upload and compression
    $photoPath = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['photo']['tmp_name'];
        $fileSize = $_FILES['photo']['size'];

        // Max file size: 3MB
        $maxFileSize = 3 * 1024 * 1024;
        if ($fileSize > $maxFileSize) {
            $response['message'] = 'Photo is too large. Max size is 3MB.';
            echo json_encode($response);
            exit;
        }

        $size = getimagesize($fileTmp);
        if (!$size || $size[0] < 100 || $size[1] < 100) {
            $response['message'] = 'Image too small. Minimum 100x100px.';
            echo json_encode($response);
            exit;
        }
        if ($size[0] > 1500 || $size[1] > 1500) {
            $response['message'] = 'Image too large. Max 1500x1500px.';
            echo json_encode($response);
            exit;
        }

        // Prepare destination
        $uploadDir = __DIR__ . '/../../uploads/profile/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $fileName = time() . '.jpg';
        $targetPath = $uploadDir . $fileName;

        // Create image resource from uploaded image
        switch ($size['mime']) {
            case 'image/jpeg':
                $srcImage = imagecreatefromjpeg($fileTmp);
                break;
            case 'image/png':
                $srcImage = imagecreatefrompng($fileTmp);
                break;
            case 'image/webp':
                $srcImage = imagecreatefromwebp($fileTmp);
                break;
            default:
                $response['message'] = 'Unsupported image format.';
                echo json_encode($response);
                exit;
        }

        if (!$srcImage) {
            $response['message'] = 'Failed to process image.';
            echo json_encode($response);
            exit;
        }

        // Resize if larger than 800x800
        $maxDim = 800;
        $origWidth = $size[0];
        $origHeight = $size[1];
        $scale = min($maxDim / $origWidth, $maxDim / $origHeight, 1);
        $newWidth = (int)($origWidth * $scale);
        $newHeight = (int)($origHeight * $scale);

        $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resizedImage, $srcImage, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        // Save compressed JPEG (quality 75)
        if (!imagejpeg($resizedImage, $targetPath, 75)) {
            $response['message'] = 'Failed to save image.';
            echo json_encode($response);
            exit;
        }

        // Set photo path relative to app root
        $photoPath = 'uploads/profile/' . $fileName;

        // Free memory
        imagedestroy($srcImage);
        imagedestroy($resizedImage);
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
