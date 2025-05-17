<?php
session_start();
require_once '../includes/db.php';

// Sanitize input
$usernameOrEmail = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Validate input
if (empty($usernameOrEmail) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Both fields are required.']);
    exit;
}

// Fetch user
$stmt = $conn->prepare("
    SELECT id, username, email, password, status, is_disabled, role, login_count, failed_attempts, last_failed_login 
    FROM users 
    WHERE username = ? OR email = ? 
    LIMIT 1
");
$stmt->bind_param('ss', $usernameOrEmail, $usernameOrEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo json_encode(['success' => false, 'message' => 'User not found.']);
    exit;
}

$user = $result->fetch_assoc();

// Check if 5 minutes have passed since last failed login
$now = new DateTime();
if ($user['last_failed_login']) {
    $lastFailed = new DateTime($user['last_failed_login']);
    $interval = $now->getTimestamp() - $lastFailed->getTimestamp();

    if ($interval > 300) { // 5 minutes = 300 seconds
        // Reset failed attempts
        $resetStmt = $conn->prepare("UPDATE users SET failed_attempts = 0, last_failed_login = NULL WHERE id = ?");
        $resetStmt->bind_param('i', $user['id']);
        $resetStmt->execute();
        $user['failed_attempts'] = 0;
    }
}

// Block login if too many failed attempts
$maxAttempts = 5;
if ($user['failed_attempts'] >= $maxAttempts) {
    echo json_encode(['success' => false, 'message' => 'Too many failed login attempts. Try again in 5 minutes.']);
    exit;
}

// Check password
if (!password_verify($password, $user['password'])) {
    // Increment failed attempts
    $newAttempts = $user['failed_attempts'] + 1;
    $nowStr = $now->format('Y-m-d H:i:s');
    $failStmt = $conn->prepare("UPDATE users SET failed_attempts = ?, last_failed_login = ? WHERE id = ?");
    $failStmt->bind_param('isi', $newAttempts, $nowStr, $user['id']);
    $failStmt->execute();

    echo json_encode(['success' => false, 'message' => 'Invalid credentials.']);
    exit;
}

// Account approval and status checks
if ($user['status'] !== 'approved') {
    echo json_encode(['success' => false, 'message' => 'Your account is not yet approved.']);
    exit;
}

if ((int)$user['is_disabled'] === 1) {
    echo json_encode(['success' => false, 'message' => 'Your account has been disabled.']);
    exit;
}

// ✅ Successful login: Reset attempts and update login info
$updateStmt = $conn->prepare("
    UPDATE users 
    SET login_count = login_count + 1, last_login_at = NOW(), failed_attempts = 0, last_failed_login = NULL 
    WHERE id = ?
");
$updateStmt->bind_param('i', $user['id']);
$updateStmt->execute();

// Regenerate session ID
session_regenerate_id(true);

// Set session variables
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_role'] = $user['role'];

// Redirect
$redirectUrl = ($user['role'] === 'co') ? '../admin/co_dashboard.php' : '../dashboard.php';
echo json_encode(['success' => true, 'redirect' => $redirectUrl]);
?>
