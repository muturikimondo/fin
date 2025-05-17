<!-- templates/alerts.php -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5 fw-bold" style="color: #00632d;">System Alerts</h2>
        <div class="row g-4">

            <!-- Alert 1 -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 hover-effect" style="background-color: #fde2e2;">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill display-5 text-danger me-4"></i>
                        <div>
                            <h5 class="card-title fw-bold text-dark">Server Maintenance</h5>
                            <p class="card-text text-dark">Scheduled maintenance tonight from 10 PM to 2 AM.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert 2 -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 hover-effect" style="background-color: #e2f0cb;">
                    <div class="card-body d-flex align-items-center">
                        <i class="bi bi-check-circle-fill display-5 text-success me-4"></i>
                        <div>
                            <h5 class="card-title fw-bold text-dark">System Update Completed</h5>
                            <p class="card-text text-dark">New features have been added successfully.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Hover CSS effect (already exists but ensuring) -->
<style>
.hover-effect:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease-in-out;
}
</style>

