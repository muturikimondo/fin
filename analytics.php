<div class="container py-4">

    <!-- KPI Cards with Icons -->
    <div class="row g-4 mb-5">
        <?php
        $cardConfigs = [
            ['Total Users', 'totalUsers', 'bi-people-fill', 'primary'],
            ['New This Month', 'newUsersMonth', 'bi-person-plus-fill', 'info'],
            ['Active This Week', 'activeThisWeek', 'bi-graph-up', 'success'],
            ['Email Verified', 'emailVerified', 'bi-envelope-check-fill', 'secondary'],
            ['Approved', 'approvedUsers', 'bi-person-check-fill', 'success'],
            ['Pending', 'pendingUsers', 'bi-hourglass-split', 'warning'],
            ['Rejected', 'rejectedUsers', 'bi-person-x-fill', 'danger'],
            ['Disabled', 'disabledUsers', 'bi-slash-circle-fill', 'dark']
        ];

        foreach ($cardConfigs as [$title, $id, $icon, $color]): ?>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm rounded-4 border border-<?= $color ?> bg-light animate__animated animate__fadeIn">
                    <div class="card-body text-center py-4">
                        <div class="mb-2">
                            <i class="bi <?= $icon ?> text-<?= $color ?> fs-3" data-bs-toggle="tooltip" title="<?= $title ?>"></i>
                        </div>
                        <h6 class="text-muted small"><?= $title ?></h6>
                        <h2 class="fw-bold mb-0" id="<?= $id ?>">0</h2>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Growth Indicator -->
    <p class="text-muted small text-end mb-4" id="growthIndicator"></p>

    <!-- Charts Section -->
    <div class="row g-4">
        <!-- Status Breakdown -->
        <div class="col-lg-6">
            <div class="card shadow-sm rounded-4 animate__animated animate__fadeIn">
                <div class="card-header text-white rounded-top-4 fw-semibold" style="background-color: #432d14;">

                    <i class="bi bi-pie-chart-fill me-2"></i>Status Breakdown
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Users by Role -->
        <div class="col-lg-6">
            <div class="card shadow-sm rounded-4 animate__animated animate__fadeIn">
                <div class="card-header text-white rounded-top-4 fw-semibold" style="background-color: #432d14;">

                    <i class="bi bi-diagram-3-fill me-2"></i>Users by Role
                </div>
                <div class="card-body">
                    <canvas id="roleChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Registrations -->
    <div class="row g-4 mt-4">
        <div class="col-12">
            <div class="card shadow-sm rounded-4 animate__animated animate__fadeIn">
                <div class="card-header text-white rounded-top-4 fw-semibold" style="background-color: #432d14;">

                    <i class="bi bi-calendar2-week-fill me-2"></i>Monthly Registrations
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- User Type Trends -->
    <div class="row g-4 mt-4">
        <div class="col-12">
            <div class="card shadow-sm rounded-4 animate__animated animate__fadeIn">
                <div class="card-header text-white rounded-top-4 fw-semibold" style="background-color: #432d14;">

                    <span><i class="bi bi-bar-chart-line-fill me-2"></i>User Role Trends Over 6 Months</span>
                    <button class="btn btn-sm btn-outline-dark" onclick="exportChart()" data-bs-toggle="tooltip" title="Export as Image">
                        <i class="bi bi-download me-1"></i> Export
                    </button>
                </div>
                <div class="card-body">
                    <canvas id="userTypeLineChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<script src="js/analytics/dashboard.js"></script>
<script>
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(el => new bootstrap.Tooltip(el));
</script>
