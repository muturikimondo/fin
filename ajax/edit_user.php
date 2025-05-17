<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Fetch user
    if (isset($_POST['edit_user_id'])) {
        $userId = intval($_POST['edit_user_id']);

        $stmt = $conn->prepare("SELECT id, username, email, role, status FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        echo json_encode($result->fetch_assoc());
        $stmt->close();
        $conn->close();
        exit;
    }

    // Update user
    if (isset($_POST['update_user_id'])) {
        $userId = intval($_POST['update_user_id']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $role = trim($_POST['role']);
        $status = trim($_POST['status']);

        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $username, $email, $role, $status, $userId);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'User updated successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update user.']);
        }

        $stmt->close();
        $conn->close();
        exit;
    }
}
?>
