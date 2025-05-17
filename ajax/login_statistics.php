<?php
require_once '../includes/db.php';

$response = [
  'totalSuccessLogins' => 0,
  'totalFailedLogins' => 0,
  'loginsToday' => 0,
  'mostLoggedInUser' => ['username' => 'N/A', 'login_count' => 0],
  'mostFailedUser' => ['username' => 'N/A', 'failed_attempts' => 0]
];

// === Fetch total successful logins ===
$sqlSuccess = "SELECT COUNT(*) as count FROM users WHERE last_login_at IS NOT NULL"; // last_login_at must not be NULL to consider it a successful login
$result = $conn->query($sqlSuccess);
if ($result && $row = $result->fetch_assoc()) {
  $response['totalSuccessLogins'] = (int)$row['count'];
}


// === Fetch total failed logins ===
$sqlFailed = "SELECT COUNT(*) as count FROM users WHERE status = 'rejected'"; // assuming 'rejected' means failed login
$result = $conn->query($sqlFailed);
if ($result && $row = $result->fetch_assoc()) {
  $response['totalFailedLogins'] = (int)$row['count'];
}

// === Fetch today's logins ===
$sqlToday = "SELECT COUNT(*) as count FROM users WHERE DATE(last_login_at) = CURDATE()";
$result = $conn->query($sqlToday);
if ($result && $row = $result->fetch_assoc()) {
  $response['loginsToday'] = (int)$row['count'];
}

// === Most logged-in user ===
$sqlMostLogins = "SELECT username, login_count FROM users ORDER BY login_count DESC LIMIT 1";
$result = $conn->query($sqlMostLogins);
if ($result && $row = $result->fetch_assoc()) {
  $response['mostLoggedInUser'] = [
    'username' => $row['username'],
    'login_count' => (int)$row['login_count']
  ];
}

// === Most failed login user ===
//$sqlMostFailed = "SELECT username, failed_attempts FROM users ORDER BY failed_attempts DESC LIMIT 1";
$sqlMostFailed = "SELECT username, failed_attempts 
                  FROM users 
                  WHERE last_failed_login IS NOT NULL
                  ORDER BY failed_attempts DESC LIMIT 1";



$result = $conn->query($sqlMostFailed);
if ($result && $row = $result->fetch_assoc()) {
  $response['mostFailedUser'] = [
    'username' => $row['username'],
    'failed_attempts' => (int)$row['failed_attempts']
  ];
}





// === Fetch active users (logged in within last 5 days) ===
$sqlActive = "SELECT COUNT(*) as count 
              FROM users 
              WHERE is_disabled = 0 
                AND last_login_at IS NOT NULL 
                AND last_login_at >= DATE_SUB(NOW(), INTERVAL 5 DAY)";
$result = $conn->query($sqlActive);
if ($result && $row = $result->fetch_assoc()) {
  $response['activeUsers'] = (int)$row['count'];
}


// === Fetch pending users ===
$sqlPending = "SELECT COUNT(*) as count FROM users WHERE status = 'pending'"; // assuming 'pending' status indicates pending users
$result = $conn->query($sqlPending);
if ($result && $row = $result->fetch_assoc()) {
  $response['pendingUsers'] = (int)$row['count'];
}

// === Fetch disabled users ===
// === Fetch disabled users ===
$sqlDisabled = "SELECT COUNT(*) as count FROM users WHERE is_disabled != 0"; // Count users where is_disabled is not 0
$result = $conn->query($sqlDisabled);
if ($result && $row = $result->fetch_assoc()) {
  $response['disabledUsers'] = (int)$row['count'];
}
header('Content-Type: application/json');
echo json_encode($response);
?>
