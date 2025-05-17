<div class="container my-5">

<style>
    .fade-in {
  animation: fadeInUp 0.6s ease-in-out;
}

@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(15px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}



</style>



<div class="card-title text-muted mb-2">
    <h3 class="mb-4 text-primary fw-bold"><i class="bi bi-bar-chart-line-fill me-2"></i>Login Dashboard</h3>
</div>
<div class= "card p-3 mb-3">

    <!-- Login Statistics Cards -->
    <div id="loginStatsCards" class="row g-3 mb-4">
      <!-- Cards will be injected here by JS -->
    </div>
</div>

    <!-- Chart Section -->
   <div class="card shadow-sm border-0 rounded mb-3">
  <!-- Card Header -->
  <div class="card-header text-white fw-bold" style="background-color: #432d14;">
    <i class="bi bi-graph-up-arrow me-2"></i>Login Trends
  </div>

  <!-- Card Body -->
  <div class="card p-3">
    <div style="height: 350px;">
      <canvas id="loginChart"></canvas>
    </div>
  </div>
</div>
  </div>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Chart Theme Colors -->
  <script>
  const countyColors = {
    light:  "rgba(0, 99, 45, 0.7)",      // Primary Green
    accent:   "rgba(2, 165, 84, 0.7)",     // Accent Green
    beige:    "rgba(194, 170, 141, 0.7)",  // Beige
    dark:     "rgba(67, 45, 20, 0.7)",     // Dark Brown
    primary:    "rgba(242, 225, 215, 0.7)"   // Light Beige
  };
</script>

  <!-- Custom JS -->
  <script src="../js/login_statistics.js"></script>