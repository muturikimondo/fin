<?php
require_once '../includes/db.php';

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$role = $_POST['role'] ?? '';
$status = $_POST['status'] ?? '';

$query = "SELECT id, username, email, role, status FROM users WHERE 1=1";
$params = [];
$types = '';

if (!empty($name)) {
    $query .= " AND username LIKE ?";
    $params[] = "%" . $name . "%";
    $types .= 's';
}

if (!empty($email)) {
    $query .= " AND email LIKE ?";
    $params[] = "%" . $email . "%";
    $types .= 's';
}

if (!empty($role)) {
    $query .= " AND role = ?";
    $params[] = $role;
    $types .= 's';
}

if (!empty($status)) {
    $query .= " AND status = ?";
    $params[] = $status;
    $types .= 's';
}

$stmt = $conn->prepare($query);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
echo json_encode($users);
?>
