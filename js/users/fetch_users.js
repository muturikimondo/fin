// fetch_users.js
import { renderPagination } from './pagination.js';

export function loadUsers(filters = {}) {
    const body = $('#usersTableBody');
    filters.page = window.currentPage || 1;
    filters.pageSize = 5;

    body.html('<div class="text-center w-100"><div class="spinner-border text-primary"></div></div>');

    $.post('../ajax/fetch_users.php', filters, function (response) {
        try {
            const res = JSON.parse(response);
            const users = res.data;
            const total = res.total;
            body.empty();

            if (!users.length) {
                body.html('<p class="text-muted">No users found.</p>');
                $('#paginationControls').empty();
                return;
            }

            users.forEach(user => {
                const row = `
                    <div class="row mb-3">
                        <div class="col-12 col-md-1 text-center">
                            <img src="/app/${user.photo || 'uploads/profile/user-plus.png'}"
                                 onerror="this.onerror=null;this.src='/app/uploads/profile/user-plus.png';"
                                 alt="${user.username}"
                                 title="${user.username}'s profile photo"
                                 class="rounded-circle img-fluid"
                                 style="width: 40px; height: 40px; object-fit: cover;">
                        </div>
                        <div class="col-12 col-md-1">${user.username}</div>
                        <div class="col-12 col-md-1">${user.email}</div>
                        <div class="col-12 col-md-1">
                            <span class="badge bg-secondary text-capitalize">${user.role}</span>
                        </div>
                        <div class="col-12 col-md-1">
                            <span class="badge ${user.status === 'approved' ? 'bg-success' : user.status === 'pending' ? 'bg-warning text-dark' : 'bg-danger'} text-capitalize">${user.status}</span>
                        </div>
                        <div class="col-12 col-md-1">${user.login_count}</div>
                        <div class="col-12 col-md-2">${user.last_login_at ?? '—'}</div>
                        <div class="col-12 col-md-2">${user.created_at}</div>
                        <div class="col-12 col-md-1 text-end">
                            <button class="btn btn-outline-primary btn-sm edit-btn me-1" data-id="${user.id}" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-sm delete-btn" data-id="${user.id}" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                body.append(row);
            });

            // Call renderPagination after rendering users
            renderPagination(window.currentPage, total, filters.pageSize, (page) => {
                window.currentPage = page;
                loadUsers({ ...filters, page });
            });

        } catch (err) {
            console.error('Failed to parse response:', err, response);
            body.html('<p class="text-danger">Failed to load users. Invalid server response.</p>');
        }
    }).fail(function (xhr) {
        console.error('Error loading users:', xhr.responseText);
        body.html('<p class="text-danger">Server error while loading users.</p>');
    });
}
