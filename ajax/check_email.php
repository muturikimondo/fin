<?php
header('Content-Type: application/json');
require_once '../includes/db.php';

$response = ['exists' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (!empty($email)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        $response['exists'] = $stmt->num_rows > 0;

        $stmt->close();
    }
}

echo json_encode($response);
$conn->close();
