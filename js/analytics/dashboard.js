document.addEventListener("DOMContentLoaded", function () {
    fetch("../ajax/get_user_analytics.php")
        .then(response => response.json())
        .then(data => {
            animateCounter("totalUsers", data.total_users);
            animateCounter("newUsersMonth", data.new_this_month);
            animateCounter("activeThisWeek", data.active_this_week);
            animateCounter("emailVerified", data.email_verified_users);
            animateCounter("approvedUsers", data.approved_users);
            animateCounter("pendingUsers", data.pending_users);
            animateCounter("rejectedUsers", data.rejected_users);
            animateCounter("disabledUsers", data.disabled_users);

            renderStatusChart(data);
            renderRoleChart(data.roles);
            renderMonthlyChart(data.monthly);
            renderUserTypeTrendChart(data.user_type_trends);
            showGrowthIndicator(data.monthly);
        })
        .catch(error => {
            console.error("Analytics Fetch Error:", error);
            alert("Failed to load dashboard data. Try again later.");
        });
});

function animateCounter(id, target) {
    const el = document.getElementById(id);
    if (!el) return;
    let start = 0;
    const duration = 1000;
    const step = Math.ceil(target / (duration / 30));
    const counter = setInterval(() => {
        start += step;
        if (start >= target) {
            el.innerText = target;
            clearInterval(counter);
        } else {
            el.innerText = start;
        }
    }, 30);
}

function showGrowthIndicator(monthly) {
    if (monthly.length >= 2) {
        const [prev, curr] = monthly.slice(-2);
        const growth = ((curr.count - prev.count) / (prev.count || 1) * 100).toFixed(1);
        const el = document.getElementById("growthIndicator");
        el.innerText = `${growth > 0 ? '+' : ''}${growth}% growth since last month`;
    }
}

// 📊 Pie chart for user statuses using brand colors
function renderStatusChart(data) {
    const ctx = document.getElementById("statusChart");
    new Chart(ctx, {
        type: "pie",
        data: {
            labels: ["Approved", "Pending", "Rejected", "Disabled"],
            datasets: [{
                data: [
                    data.approved_users,
                    data.pending_users,
                    data.rejected_users,
                    data.disabled_users
                ],
                backgroundColor: [
                    "rgba(0, 99, 45, 0.7)",     // primary
                    "rgba(194, 170, 141, 0.7)", // beige
                    "rgba(67, 45, 20, 0.7)",    // dark
                    "rgba(242, 225, 215, 0.7)"  // light
                ],
                borderColor: "#fff",
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: "bottom" }
            }
        }
    });
}

// 🍩 Role chart with faded brand palette
function renderRoleChart(roles) {
    const ctx = document.getElementById("roleChart");
    new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: roles.map(r => r.role),
            datasets: [{
                data: roles.map(r => r.count),
                backgroundColor: generateBrandFadedColors(roles.length),
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { enabled: true }
            }
        }
    });
}

// 📈 Monthly bar chart
function renderMonthlyChart(monthly) {
    const ctx = document.getElementById("monthlyChart");
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: monthly.map(m => m.month),
            datasets: [{
                label: "Monthly Signups",
                data: monthly.map(m => m.count),
                backgroundColor: "rgba(2, 165, 84, 0.7)", // accent
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } },
            plugins: {
                tooltip: { enabled: true },
                legend: { display: false }
            }
        }
    });
}

// 📉 Line chart with brand-based colors
function renderUserTypeTrendChart(userTypeTrends) {
    const ctx = document.getElementById("userTypeLineChart");
    const colors = generateBrandFadedColors(userTypeTrends.series.length);

    new Chart(ctx, {
        type: "line",
        data: {
            labels: userTypeTrends.months,
            datasets: userTypeTrends.series.map((s, i) => ({
                label: s.user_type,
                data: s.data,
                fill: true,
                backgroundColor: colors[i].replace("0.7", "0.2"),
                borderColor: colors[i],
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6
            }))
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                tooltip: { mode: 'index', intersect: false }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            }
        }
    });
}

function exportChart() {
    const canvas = document.getElementById("userTypeLineChart");
    canvas.toBlob(blob => saveAs(blob, "user-role-trends.png"));
}

// 🎨 Brand color palette with fade (70% opacity)
function generateBrandFadedColors(count) {
    const brandFaded = [
        "rgba(0, 99, 45, 0.7)",     // primary
        "rgba(2, 165, 84, 0.7)",    // accent
        "rgba(194, 170, 141, 0.7)", // beige
        "rgba(67, 45, 20, 0.7)",    // dark
        "rgba(242, 225, 215, 0.7)"  // light
    ];
    const colors = [];
    for (let i = 0; i < count; i++) {
        colors.push(brandFaded[i % brandFaded.length]);
    }
    return colors;
}
