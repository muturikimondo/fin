<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../includes/db.php';
header('Content-Type: application/json');

$data = [
    'total_users' => 0,
    'approved_users' => 0,
    'pending_users' => 0,
    'rejected_users' => 0,
    'disabled_users' => 0,
    'email_verified_users' => 0,
    'new_this_month' => 0,
    'active_this_week' => 0,
    'roles' => [],
    'monthly' => [],
    'user_type_trends' => []
];

// Status counts
$statusQuery = "SELECT status, COUNT(*) as total FROM users GROUP BY status";
$res = $conn->query($statusQuery);
while ($row = $res->fetch_assoc()) {
    $key = strtolower($row['status']);
    $count = (int)$row['total'];
    $data["{$key}_users"] = $count;
    if ($key === 'approved') $data['email_verified_users'] = $count;
    $data['total_users'] += $count;
}

// New this month
$monthStart = date('Y-m-01');
$now = date('Y-m-d');
$res = $conn->query("SELECT COUNT(*) AS total FROM users WHERE created_at BETWEEN '$monthStart' AND '$now'");
$data['new_this_month'] = (int)($res->fetch_assoc()['total'] ?? 0);

// Active this week
$weekAgo = date('Y-m-d', strtotime('-7 days'));
$res = $conn->query("SELECT COUNT(*) AS total FROM users WHERE last_login_at >= '$weekAgo'");
$data['active_this_week'] = (int)($res->fetch_assoc()['total'] ?? 0);

// Roles
$res = $conn->query("SELECT role, COUNT(*) as total FROM users GROUP BY role");
while ($row = $res->fetch_assoc()) {
    $data['roles'][] = ['role' => $row['role'], 'count' => (int)$row['total']];
}

// Monthly registrations
$monthly = [];
$res = $conn->query("
    SELECT DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count
    FROM users
    WHERE created_at IS NOT NULL
    GROUP BY month
    ORDER BY month DESC
    LIMIT 6
");
while ($row = $res->fetch_assoc()) {
    $monthly[] = ['month' => $row['month'], 'count' => (int)$row['count']];
}
$data['monthly'] = array_reverse($monthly);

// User type trends
$res = $conn->query("
    SELECT role, DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count
    FROM users
    WHERE created_at IS NOT NULL
    GROUP BY role, month
    ORDER BY month DESC
");

$typeMap = [];
while ($row = $res->fetch_assoc()) {
    $typeMap[$row['role']][$row['month']] = (int)$row['count'];
}

$months = array_column($data['monthly'], 'month');
$typeSeries = [];
foreach ($typeMap as $role => $values) {
    $series = [];
    foreach ($months as $m) {
        $series[] = $values[$m] ?? 0;
    }
    $typeSeries[] = ['user_type' => $role, 'data' => $series];
}
$data['user_type_trends'] = ['months' => $months, 'series' => $typeSeries];

echo json_encode($data);
exit;
?>
