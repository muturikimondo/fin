<?php
// ~/Sites/laikipia/dashboard.php
session_start();

// Protect the page
if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit;
}

// Include templates and DB connection
include 'templates/header.php';
include 'templates/nav.php';
include 'includes/db.php';

// Fetch user statistics
$userId = $_SESSION['user_id'];
$stmt = $conn->prepare(
    "SELECT username, login_count, last_login_at, created_at
     FROM users
     WHERE id = ?"
);
$stmt->bind_param('i', $userId);
$stmt->execute();
$stmt->bind_result(
    $username,
    $loginCount,
    $lastLoginAt,
    $createdAt
);
$stmt->fetch();
$stmt->close();

// Prepare display values
$lastLoginDisplay = $lastLoginAt
    ? date('d M Y, H:i:s', strtotime($lastLoginAt))
    : 'Never';
$memberSinceDisplay = $createdAt
    ? date('d M Y', strtotime($createdAt))
    : 'Unknown';
?>

<main class="container py-5">
    <div class="row mb-4">
        <div class="col text-center">
            <h1 class="fw-bold" style="color: var(--primary-color);">
                Welcome back, <?= htmlspecialchars($username ?? 'User') ?>!
            </h1>
        </div>
    </div>

    <!-- Logout Button -->
    <div class="text-end mb-4">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <div class="row g-4">
        <!-- Total Logins -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 hover-effect" style="background-color: var(--light-color);">
                <div class="card-body text-center">
                    <i class="bi bi-bar-chart-line display-3 text-success mb-3"></i>
                    <h5 class="card-title fw-bold text-dark">Total Logins</h5>
                    <h3 class="fw-bold text-dark"><?= htmlspecialchars((string)($loginCount ?? 0)) ?></h3>
                </div>
            </div>
        </div>

        <!-- Last Login -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 hover-effect" style="background-color: var(--light-color);">
                <div class="card-body text-center">
                    <i class="bi bi-clock display-3 text-success mb-3"></i>
                    <h5 class="card-title fw-bold text-dark">Last Login</h5>
                    <p class="text-dark mb-0"><?= htmlspecialchars($lastLoginDisplay) ?></p>
                </div>
            </div>
        </div>

        <!-- Member Since -->
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 hover-effect" style="background-color: var(--light-color);">
                <div class="card-body text-center">
                    <i class="bi bi-calendar2-date display-3 text-success mb-3"></i>
                    <h5 class="card-title fw-bold text-dark">Member Since</h5>
                    <p class="text-dark mb-0"><?= htmlspecialchars($memberSinceDisplay) ?></p>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'templates/footer.php'; ?>

