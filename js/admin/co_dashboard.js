document.addEventListener('DOMContentLoaded', () => {
    // Approve user
    document.querySelectorAll('.approve-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const userId = btn.getAttribute('data-id');
            if (confirm('Are you sure you want to approve this user?')) {
                fetch('../ajax/approve_user.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id=${encodeURIComponent(userId)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`user-row-${userId}`).remove();
                        alert('User approved successfully.');
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(err => alert('Request failed.'));
            }
        });
    });

    // Reject user
    document.querySelectorAll('.reject-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const userId = btn.getAttribute('data-id');
            if (confirm('Are you sure you want to reject this user?')) {
                fetch('../ajax/reject_user.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `id=${encodeURIComponent(userId)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById(`user-row-${userId}`).remove();
                        alert('User rejected.');
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(err => alert('Request failed.'));
            }
        });
    });
});
