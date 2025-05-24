<?php
require_once '../includes/db.php';
require_once '../includes/config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'co') {
    header('Location: ' . asset('auth/login.php'));
    exit;
}

include '../templates/header.php';
?>

<div class="container-fluid py-5">
    <!-- Page Header -->
    <div class="row mb-4">
        <!-- Optional Title and Tagline -->
        <!-- <div class="col-12 text-center">
            <h1 class="display-5 text-<?php //echo $brand_colors['accent']; ?>"><?php //echo $site_title; ?> Dashboard</h1>
            <p class="lead text-muted"><?php //echo $site_tagline; ?></p>
        </div> -->
    </div>

    <!-- Dashboard Content -->
    <div class="row gy-4">
        <!-- Pending Users Section -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm rounded-4">
                <div class="card-header bg-<?php echo $brand_colors['light']; ?> text-white rounded-top-4">
                    <h5 class="fs-5 fw-semibold mb-0">
                        <h3 class="mb-4 fw-bold" style="color: #432d14;">
                            <i class="bi bi-person-check-fill me-2"></i>
                            Pending Users Actions
                        </h3>
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="container-fluid">
                        <div class="row fw-bold text-white py-2 border-bottom small text-uppercase" style="background-color: #432d14;">
                            <div class="col-1">#</div>
                            <div class="col-3">Username</div>
                            <div class="col-3">Email</div>
                            <div class="col-2 d-none d-md-block">Role</div>
                            <div class="col-3">Actions</div>
                        </div>

                        <?php
                        $result = $conn->query("SELECT id, username, email, role FROM users WHERE status = 'pending'");
                        if ($result->num_rows > 0) {
                            $i = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo '
                                <div class="row align-items-center py-2 border-bottom user-row" id="user-row-' . $row['id'] . '">
                                    <div class="col-1">' . $i . '</div>
                                    <div class="col-3">' . htmlspecialchars($row['username']) . '</div>
                                    <div class="col-3 text-truncate" title="' . htmlspecialchars($row['email']) . '">' . htmlspecialchars($row['email']) . '</div>
                                    <div class="col-2 d-none d-md-block">' . htmlspecialchars($row['role']) . '</div>
                                    <div class="col-3">
                                        <button class="btn btn-outline-success btn-sm approve-btn me-1" data-id="' . $row['id'] . '" title="Approve">
                                            <i class="bi bi-check2-circle"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-sm reject-btn" data-id="' . $row['id'] . '" title="Reject">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                    </div>
                                </div>';
                                $i++;
                            }
                        } else {
                            echo '
                            <div class="row py-3">
                                <div class="col text-center text-muted">No pending user registrations.</div>
                            </div>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Optional Dashboard Panel -->
            <div class="mt-4">
                <?php include '../templates/login_dashboard.php'; ?>
            </div>
            
        </div>

        <!-- Overview Section -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm rounded-4">
                <div class="card-header text-white rounded-top-4" style="background-color: <?php echo $brand_colors['dark']; ?>;">
                    <h5 class="fs-5 fw-semibold mb-0">
                        <h3 class="mb-4 text-white fw-bold"><i class="bi bi-person-plus-fill me-2"></i>
                            Users Dashboard
                        </h3>
                    </h5>
                </div>
                <div class="card-body p-4">
                    <?php include '../analytics.php'; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Row here to show my users list -->
    <p>
    <div class="row">
        <div class="col-12">
            <div class="card p-2 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <?php include '../test/index.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
</div>

<?php include '../templates/footer.php'; ?>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="module" src="<?php echo asset('js/analytics/dashboard.js'); ?>"></script>
<script type="module" src="<?php echo asset('js/admin/co_dashboard.js'); ?>"></script>
