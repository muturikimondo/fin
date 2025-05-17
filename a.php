<?php
session_start();
require_once 'includes/db.php';
include 'templates/header.php';
?>

<div class="container py-4">
    <h2 class="mb-4 text-primary">
        <i class="bi bi-bar-chart-line"></i> User Analytics Dashboard
    </h2>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="text-primary"><i class="bi bi-people"></i> Total Users</h5>
                    <h3 id="totalUsers">...</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="text-success"><i class="bi bi-person-check"></i> Approved</h5>
                    <h3 id="approvedUsers">...</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="text-warning"><i class="bi bi-hourglass-split"></i> Pending</h5>
                    <h3 id="pendingUsers">...</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="text-danger"><i class="bi bi-person-x"></i> Rejected</h5>
                    <h3 id="rejectedUsers">...</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row mt-5">
        <div class="col-lg-6 mb-4">
            <canvas id="roleChart"></canvas>
        </div>
        <div class="col-lg-6 mb-4">
            <canvas id="monthlyChart"></canvas>
        </div>
        <div class="col-12 mb-4">
            <canvas id="userTypeLineChart"></canvas>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="js/analytics/dashboard.js"></script>