<?php
// ajax/reject_user.php

header('Content-Type: application/json');

// Include the database connection
require_once __DIR__ . '/../includes/db.php';

// Validate the incoming ID
if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'message' => 'User ID is missing.']);
    exit;
}

$userId = (int)$_POST['id']; // Safe cast to integer

// Prepare the SQL statement
$sql = "UPDATE users SET status = 'rejected' WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Database preparation error.']);
    exit;
}

$stmt->bind_param('i', $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'User rejected successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to reject user.']);
}

$stmt->close();
$conn->close();
?>
