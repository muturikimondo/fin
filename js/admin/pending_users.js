document.addEventListener('DOMContentLoaded', () => {
    fetch('ajax/get_user_analytics.php')
        .then(res => res.json())
        .then(data => {
            document.getElementById('totalUsers').textContent = data.total;
            document.getElementById('approvedUsers').textContent = data.approved;
            document.getElementById('pendingUsers').textContent = data.pending;
            document.getElementById('rejectedUsers').textContent = data.rejected;

            // Role Doughnut Chart
            const roleCtx = document.getElementById('roleChart');
            new Chart(roleCtx, {
                type: 'doughnut',
                data: {
                    labels: data.roles.map(r => r.role),
                    datasets: [{
                        data: data.roles.map(r => r.count),
                        backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1']
                    }]
                },
                options: {
                    plugins: {
                        legend: { position: 'bottom' },
                        title: { display: true, text: 'Users by Role' }
                    }
                }
            });

            // Monthly Bar Chart
            const monthCtx = document.getElementById('monthlyChart');
            new Chart(monthCtx, {
                type: 'bar',
                data: {
                    labels: data.monthly.map(m => m.month),
                    datasets: [{
                        label: 'Registrations',
                        data: data.monthly.map(m => m.count),
                        backgroundColor: '#0d6efd'
                    }]
                },
                options: {
                    scales: { y: { beginAtZero: true } },
                    plugins: {
                        legend: { display: false },
                        title: { display: true, text: 'Monthly Registrations' }
                    }
                }
            });

            // User Type Line Chart
            const trendCtx = document.getElementById('userTypeLineChart');
            const colors = ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1'];
            const datasets = data.user_type_trends.series.map((s, i) => ({
                label: s.user_type,
                data: s.data,
                borderColor: colors[i % colors.length],
                tension: 0.3,
                fill: false
            }));
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: data.user_type_trends.months,
                    datasets
                },
                options: {
                    plugins: {
                        legend: { position: 'bottom' },
                        title: { display: true, text: 'User Registrations by Type' }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        })
        .catch(err => console.error('Analytics load error:', err));
});
