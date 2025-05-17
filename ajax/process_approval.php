<?php
// ajax/process_approval.php
require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/mailer.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $action = $_POST['action'];

    $newStatus = ($action === 'approve') ? 'approved' : 'rejected';

    // Fetch user details
    $stmt = $conn->prepare("SELECT email, username FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($email, $username);
    $stmt->fetch();
    $stmt->close();

    // Update status
    $update = $conn->prepare("UPDATE users SET status = ? WHERE id = ?");
    $update->bind_param("si", $newStatus, $id);

    if ($update->execute()) {
        // Send email
        sendUserStatusNotification($username, $email, $newStatus);
        echo json_encode(["success" => true, "message" => "User $action successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update user status."]);
    }
}
?>

