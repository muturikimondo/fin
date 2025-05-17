<?php
// ../ajax/login_trend_data.php

require_once '../includes/db.php';

header('Content-Type: application/json');

$sql = "SELECT DATE(last_login_at) as login_date, COUNT(*) as count
        FROM users
        WHERE last_login_at IS NOT NULL
        GROUP BY login_date
        ORDER BY login_date ASC
        LIMIT 30";

$result = mysqli_query($conn, $sql);

$labels = [];
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $labels[] = $row['login_date'];
    $data[] = (int)$row['count'];
}

echo json_encode([
    'labels' => $labels,
    'data' => $data
]);
?>
