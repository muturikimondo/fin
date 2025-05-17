<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $userId = intval($_POST['delete_user_id']);

    $query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'User deleted successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete user.']);
    }

    $stmt->close();
    $conn->close();
}
?>
