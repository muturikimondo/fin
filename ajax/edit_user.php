<?php
// Include DB connection (adjust path if needed)
require_once __DIR__ . '/../includes/db.php';

header('Content-Type: application/json');

// Utility: consistent JSON error response with HTTP code
function errorResponse($message, $code = 400) {
    http_response_code($code);
    echo json_encode(['status' => 'error', 'message' => $message]);
    error_log("[edit_user.php][ERROR $code] $message");  // Log error message
    exit;
}

// Utility: consistent JSON success response
function successResponse($dataOrMessage) {
    http_response_code(200);
    echo is_array($dataOrMessage)
        ? json_encode(['status' => 'success', 'data' => $dataOrMessage])
        : json_encode(['status' => 'success', 'message' => $dataOrMessage]);
    error_log("[edit_user.php][SUCCESS] " . (is_array($dataOrMessage) ? json_encode($dataOrMessage) : $dataOrMessage));
    exit;
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        errorResponse('Invalid HTTP method. POST required.', 405);
    }

    // CASE 1: Fetch user by ID
    if (isset($_POST['edit_user_id'])) {
        $userId = filter_var($_POST['edit_user_id'], FILTER_VALIDATE_INT);
        if (!$userId) {
            errorResponse('Invalid user ID.');
        }

        $stmt = $conn->prepare("SELECT id, username, email, role, status, photo FROM users WHERE id = ?");
        if (!$stmt) {
            errorResponse('Failed to prepare statement: ' . $conn->error, 500);
        }
        $stmt->bind_param("i", $userId);
        if (!$stmt->execute()) {
            errorResponse('Database execute error: ' . $stmt->error, 500);
        }

        $result = $stmt->get_result();
        if ($user = $result->fetch_assoc()) {
            successResponse($user);
        } else {
            errorResponse('User not found.', 404);
        }
    }

    // CASE 2: Update user details
    if (isset($_POST['update_user_id']) || isset($_POST['userId'])) {
        $userId = filter_var($_POST['update_user_id'] ?? $_POST['userId'], FILTER_VALIDATE_INT);
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $role = trim($_POST['role'] ?? '');
        $status = trim($_POST['status'] ?? '');
        $newPassword = isset($_POST['newPassword']) ? trim($_POST['newPassword']) : null;
        $photo = $_FILES['photo'] ?? null;

        error_log("[edit_user.php] Starting update for user ID: $userId");
        error_log("[edit_user.php] Username: $username, Email: $email, Role: $role, Status: $status");

        if (!$userId || !$username || !$email || !$role || !$status) {
            errorResponse('All required fields must be provided.');
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            errorResponse('Invalid email format.');
        }

        // Handle photo upload
        $photoPath = null;
        if ($photo && $photo['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($photo['error'] !== UPLOAD_ERR_OK) {
                errorResponse('Photo upload error code: ' . $photo['error']);
            }

            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($photo['type'], $allowedMimeTypes)) {
                errorResponse('Invalid photo format. Only JPG, PNG, and GIF allowed.');
            }

            if ($photo['size'] > 5 * 1024 * 1024) {
                errorResponse('Photo size exceeds 5MB.');
            }

            $uploadDir = __DIR__ . '/../uploads/profile/';
            if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
                errorResponse('Failed to create upload directory.');
            }

            $ext = pathinfo($photo['name'], PATHINFO_EXTENSION);
            $photoName = uniqid('user_', true) . '.' . $ext;
            $photoPath = 'uploads/profile/' . $photoName; // relative path for DB storage

            $fullUploadPath = __DIR__ . '/../' . $photoPath;
            if (!move_uploaded_file($photo['tmp_name'], $fullUploadPath)) {
                errorResponse('Failed to move uploaded photo.');
            }
            error_log("[edit_user.php] Uploaded photo saved to: $photoPath");
        }

        // Hash new password if set
        if ($newPassword) {
            if (strlen($newPassword) < 6) {
                errorResponse('Password must be at least 6 characters.');
            }
            $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        // Build update query dynamically
        $updateFields = "username = ?, email = ?, role = ?, status = ?, updated_at = NOW()";
        $bindTypes = "ssss";
        $bindValues = [$username, $email, $role, $status];

        if ($photoPath) {
            $updateFields .= ", photo = ?";
            $bindTypes .= "s";
            $bindValues[] = $photoPath;
        }

        if ($newPassword) {
            $updateFields .= ", password = ?";
            $bindTypes .= "s";
            $bindValues[] = $passwordHash;
        }

        $updateQuery = "UPDATE users SET $updateFields WHERE id = ?";
        $bindTypes .= "i";
        $bindValues[] = $userId;

        $stmt = $conn->prepare($updateQuery);
        if (!$stmt) {
            errorResponse('Failed to prepare update statement: ' . $conn->error, 500);
        }

        $stmt->bind_param($bindTypes, ...$bindValues);

        if ($stmt->execute()) {
            error_log("[edit_user.php] User ID $userId updated successfully.");
            successResponse('User updated successfully.');
        } else {
            error_log("[edit_user.php][SQL ERROR] " . $stmt->error);
            errorResponse('Failed to update user.', 500);
        }
    }

    errorResponse('Invalid or missing parameters.', 400);

} catch (Exception $e) {
    error_log("[edit_user.php][EXCEPTION] " . $e->getMessage());
    errorResponse('Unexpected error occurred.', 500);
}
