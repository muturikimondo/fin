<?php
require_once '../includes/db.php';

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$role = $_POST['role'] ?? '';
$status = $_POST['status'] ?? '';
$loginCount = $_POST['login_count'] ?? '';
$lastLoginAt = $_POST['last_login_at'] ?? '';
$createdAt = $_POST['created_at'] ?? '';
$photo = $_POST['photo'] ?? '';

$page = max(1, (int)($_POST['page'] ?? 1));
$pageSize = max(1, (int)($_POST['pageSize'] ?? 5));

$offset = ($page - 1) * $pageSize;

// Base query
$baseQuery = "FROM users WHERE 1=1";
$params = [];
$types = '';

if (!empty($name)) {
    $baseQuery .= " AND username LIKE ?";
    $params[] = '%' . $name . '%';
    $types .= 's';
}
if (!empty($email)) {
    $baseQuery .= " AND email LIKE ?";
    $params[] = '%' . $email . '%';
    $types .= 's';
}
if (!empty($role)) {
    $baseQuery .= " AND role = ?";
    $params[] = $role;
    $types .= 's';
}
if (!empty($status)) {
    $baseQuery .= " AND status = ?";
    $params[] = $status;
    $types .= 's';
}

// Total count
$countQuery = "SELECT COUNT(*) $baseQuery";
$countStmt = $conn->prepare($countQuery);
if ($params) {
    $countStmt->bind_param($types, ...$params);
}
$countStmt->execute();
$countStmt->bind_result($total);
$countStmt->fetch();
$countStmt->close();

// Paginated results
$dataQuery = "SELECT id, username, email, role, status, login_count, last_login_at, created_at,photo $baseQuery LIMIT ? OFFSET ?";
$dataStmt = $conn->prepare($dataQuery);


// Add limit and offset to params
$paginatedParams = $params;
$paginatedTypes = $types . 'ii';
$paginatedParams[] = $pageSize;
$paginatedParams[] = $offset;

$dataStmt->bind_param($paginatedTypes, ...$paginatedParams);
$dataStmt->execute();
$result = $dataStmt->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode([
    'data' => $users,
    'total' => $total
]);
?>
