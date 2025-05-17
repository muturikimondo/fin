$(document).ready(function () {
    // Load and render users
    function loadUsers(filters = {}) {
        const body = $('#usersTableBody'); // Only the table body is dynamic
        const grid = $('#usersGrid');      // Outer static card container

        body.html('<div class="text-center w-100"><div class="spinner-border text-primary"></div></div>');

        $.post('../ajax/fetch_users.php', filters, function (response) {
            try {
                const users = JSON.parse(response);
                body.empty();

                if (users.length === 0) {
                    body.html('<p class="text-muted">No users found.</p>');
                    return;
                }

                users.forEach(user => {
                    const row = `
                        <div class="row align-items-center mb-2 pb-2">
                            <div class="col-12 col-md-2">${user.username}</div>
                            <div class="col-12 col-md-3">${user.email}</div>
                            <div class="col-12 col-md-2">${user.role}</div>
                            <div class="col-12 col-md-2">${user.status}</div>
                            <div class="col-12 col-md-3">
                                <button class="btn btn-sm btn-primary edit-btn" data-id="${user.id}">Edit</button>
                                <button class="btn btn-sm btn-danger delete-btn" data-id="${user.id}">Delete</button>
                            </div>
                        </div>
                    `;
                    body.append(row);
                });
            } catch (err) {
                body.html('<p class="text-danger">Failed to load users. Check console.</p>');
                console.error('Failed to parse response:', response);
            }
        }).fail(function (xhr) {
            console.error('Error loading users:', xhr.responseText);
            body.html('<p class="text-danger">Server error while loading users.</p>');
        });
    }

    // Initial load
    loadUsers();

    // Filter/search change handlers
    $('#searchName, #searchEmail, #filterRole, #filterStatus').on('input change', function () {
        const filters = {
            name: $('#searchName').val(),
            email: $('#searchEmail').val(),
            role: $('#filterRole').val(),
            status: $('#filterStatus').val()
        };
        loadUsers(filters);
    });

    // Clear filters
    $('#clearFilters').on('click', function () {
        $('#searchName').val('');
        $('#searchEmail').val('');
        $('#filterRole').val('');
        $('#filterStatus').val('');
        loadUsers();
    });

    // DELETE USER
    $(document).on('click', '.delete-btn', function () {
        const userId = $(this).data('id');
        console.log('Attempting to delete user ID:', userId);

        bootbox.confirm({
            title: 'Confirm Delete',
            message: 'Are you sure you want to delete this user?',
            buttons: {
                cancel: {
                    label: 'Cancel',
                    className: 'btn-secondary'
                },
                confirm: {
                    label: 'Delete',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if (result) {
                    $.post('../ajax/delete_user.php', { delete_user_id: userId }, function (response) {
                        try {
                            const res = JSON.parse(response);
                            bootbox.alert(res.message, function () {
                                if (res.status === 'success') loadUsers();
                            });
                        } catch (e) {
                            console.error('Delete response error:', response);
                            bootbox.alert('Failed to delete user. Try again.');
                        }
                    }).fail(function (xhr) {
                        console.error('AJAX delete failed:', xhr.responseText);
                        bootbox.alert('Server error while deleting user.');
                    });
                }
            }
        });
    });

    // FETCH USER DATA FOR EDIT
    $(document).on('click', '.edit-btn', function () {
        const userId = $(this).data('id');
        console.log('Editing user ID:', userId);

        $.post('../ajax/edit_user.php', { edit_user_id: userId }, function (response) {
            try {
                const user = JSON.parse(response);
                $('#editUserModal #userId').val(user.id);
                $('#editUserModal #username').val(user.username);
                $('#editUserModal #email').val(user.email);
                $('#editUserModal #role').val(user.role);
                $('#editUserModal #status').val(user.status);
                $('#editUserModal').modal('show');
            } catch (err) {
                console.error('Failed to parse edit data:', response);
                bootbox.alert('Failed to load user data for editing.');
            }
        }).fail(function (xhr) {
            console.error('AJAX fetch failed:', xhr.responseText);
            bootbox.alert('Server error while loading user data.');
        });
    });

    // HANDLE FORM SUBMIT (UPDATE)
    $('#editUserForm').submit(function (e) {
        e.preventDefault();

        const formData = $(this).serialize();
        console.log('Submitting update:', formData);

        $.post('../ajax/edit_user.php', formData, function (response) {
            try {
                const res = JSON.parse(response);
                bootbox.alert(res.message, function () {
                    if (res.status === 'success') {
                        $('#editUserModal').modal('hide');
                        loadUsers();
                    }
                });
            } catch (err) {
                console.error('Edit response error:', response);
                bootbox.alert('Failed to update user. Try again.');
            }
        }).fail(function (xhr) {
            console.error('AJAX update failed:', xhr.responseText);
            bootbox.alert('Server error while updating user.');
        });
    });
});
