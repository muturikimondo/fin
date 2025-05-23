export function bindDeleteUser(onSuccess) {
    $(document).on('click', '.delete-btn', function () {
        const userId = $(this).data('id');
        bootbox.confirm({
            title: 'Confirm Delete',
            message: 'Are you sure you want to delete this user?',
            buttons: {
                cancel: { label: 'Cancel', className: 'btn-secondary' },
                confirm: { label: 'Delete', className: 'btn-danger' }
            },
            callback: function (result) {
                if (result) {
                    $.post('../ajax/delete_user.php', { delete_user_id: userId }, function (response) {
                        try {
                            const res = JSON.parse(response);
                            bootbox.alert(res.message, function () {
                                if (res.status === 'success') onSuccess();
                            });
                        } catch (e) {
                            console.error('Delete response error:', e, response);
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
}
