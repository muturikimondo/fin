// js/login_statistics.js

document.addEventListener("DOMContentLoaded", function () {
  loadLoginStatsCards();
  renderLoginTrendsChart();
});

function loadLoginStatsCards() {
  fetch("../ajax/login_statistics.php")
    .then((res) => res.json())
    .then((data) => {
      const cardHtml = `
        <div class="col-md-4 col-sm-6 fade-in">
          <div class="card rounded shadow-lg border-0 mb-3">
            <div class="card-body d-flex align-items-center">
              <i class="bi bi-check-circle-fill fs-2 text-success me-3"></i>
              <div>
                <h6 class="card-title text-muted">Total Successful Logins</h6>
                <p class="fs-4 fw-semibold mb-0">${data.totalSuccessLogins}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6 fade-in">
          <div class="card rounded shadow-lg border-0 mb-3">
            <div class="card-body d-flex align-items-center">
              <i class="bi bi-x-circle-fill fs-2 text-danger me-3"></i>
              <div>
                <h6 class="card-title text-muted">Total Failed Login Attempts</h6>
                <p class="fs-4 fw-semibold mb-0">${data.totalFailedLogins}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6 fade-in">
          <div class="card rounded shadow-lg border-0 mb-3">
            <div class="card-body d-flex align-items-center">
              <i class="bi bi-person-check-fill fs-2 text-primary me-3"></i>
              <div>
                <h6 class="card-title text-muted">User with Most Logins</h6>
                <p class="fs-5 mb-0"><strong>${data.mostLoggedInUser.username}</strong> (${data.mostLoggedInUser.login_count} logins)</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6 fade-in">
          <div class="card rounded shadow-lg border-0 mb-3">
            <div class="card-body d-flex align-items-center">
              <i class="bi bi-person-exclamation fs-2 text-warning me-3"></i>
              <div>
                <h6 class="card-title text-muted">User with Most Failed Logins</h6>
                <p class="fs-5 mb-0"><strong>${data.mostFailedUser.username}</strong> (${data.mostFailedUser.failed_attempts} failed attempts)</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6 fade-in">
          <div class="card rounded shadow-lg border-0 mb-3">
            <div class="card-body d-flex align-items-center">
              <i class="bi bi-calendar-day fs-2 text-info me-3"></i>
              <div>
                <h6 class="card-title text-muted">Today's Logins</h6>
                <p class="fs-4 fw-semibold mb-0">${data.loginsToday}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6 fade-in">
          <div class="card rounded shadow-lg border-0 mb-3">
            <div class="card-body d-flex align-items-center">
              <i class="bi bi-people-fill fs-2 text-success me-3"></i>
              <div>
                <h6 class="card-title text-muted">Active Users</h6>
                <p class="fs-4 fw-semibold mb-0">${data.activeUsers}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6 fade-in">
          <div class="card rounded shadow-lg border-0 mb-3">
            <div class="card-body d-flex align-items-center">
              <i class="bi bi-person-dash-fill fs-2 text-secondary me-3"></i>
              <div>
                <h6 class="card-title text-muted">Disabled Accounts</h6>
                <p class="fs-4 fw-semibold mb-0">${data.disabledUsers}</p>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 col-sm-6 fade-in">
          <div class="card rounded shadow-lg border-0 mb-3">
            <div class="card-body d-flex align-items-center">
              <i class="bi bi-clock-fill fs-2 text-muted me-3"></i>
              <div>
                <h6 class="card-title text-muted">Pending Users</h6>
                <p class="fs-4 fw-semibold mb-0">${data.pendingUsers}</p>
              </div>
            </div>
          </div>
        </div>
      `;

      document.getElementById("loginStatsCards").innerHTML = cardHtml;
    })
    .catch((err) => {
      console.error("Error loading login statistics cards:", err);
    });
}

function renderLoginTrendsChart() {
  fetch("../ajax/login_trend_data.php")
    .then((res) => res.json())
    .then((data) => {
      const ctx = document.getElementById("loginChart").getContext("2d");

      new Chart(ctx, {
  type: "line",
  data: {
    labels: data.labels,
    datasets: [
      {
        label: "Logins",
        data: data.data,
        borderColor: "#c2aa8d", // light
        backgroundColor: "#f2e1d7", // light
        fill: true,
        tension: 0.3,
        pointRadius: 3,
        pointBackgroundColor: "#c2aa8d", // beige
      },
    ],
  },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: true,
              labels: {
                color: "#333",
              },
            },
          },
          scales: {
            x: {
              ticks: { color: "#333" },
              grid: { color: "#eee" },
            },
            y: {
              beginAtZero: true,
              ticks: { color: "#333" },
              grid: { color: "#eee" },
            },
          },
        },
      });
    })
    .catch((err) => {
      console.error("Error loading chart data:", err);
    });
}
