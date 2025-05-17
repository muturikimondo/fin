document.addEventListener('DOMContentLoaded', () => {
    fetch('ajax/get_user_analytics.php')
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            // Update counters
            document.getElementById('totalUsers').textContent = data.total;
            document.getElementById('approvedUsers').textContent = data.approved || 0;
            document.getElementById('pendingUsers').textContent = data.pending || 0;
            document.getElementById('rejectedUsers').textContent = data.rejected || 0;

            // Role distribution chart
            const roleLabels = data.roles.map(item => item.role);
            const roleCounts = data.roles.map(item => item.count);
            new Chart(document.getElementById('roleChart'), {
                type: 'doughnut',
                data: {
                    labels: roleLabels,
                    datasets: [{
                        label: 'User Roles',
                        data: roleCounts,
                        backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6c757d'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });

            // Monthly registration chart
            const monthLabels = data.monthly.map(item => item.month);
            const monthCounts = data.monthly.map(item => item.count);
            new Chart(document.getElementById('monthlyChart'), {
                type: 'bar',
                data: {
                    labels: monthLabels,
                    datasets: [{
                        label: 'Registrations',
                        data: monthCounts,
                        backgroundColor: '#0d6efd'
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // Line chart for user type trends (using roles)
            const trendLabels = data.user_type_trends.months;
            const trendSeries = data.user_type_trends.series.map(series => ({
                label: series.user_type,
                data: series.data,
                fill: false,
                borderColor: getRandomColor(),
                tension: 0.1
            }));
            new Chart(document.getElementById('userTypeLineChart'), {
                type: 'line',
                data: {
                    labels: trendLabels,
                    datasets: trendSeries
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Fetch error:', error);
        });
});

// Utility function to generate random color
function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) color += letters[Math.floor(Math.random() * 16)];
    return color;
}
