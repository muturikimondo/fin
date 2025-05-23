export function bindEditUser() {
    $(document).on('click', '.edit-btn', function () {
        const userId = $(this).data('id');

        $.post('../ajax/edit_user.php', { edit_user_id: userId }, function (response) {
            try {
                const res = typeof response === 'string' ? JSON.parse(response) : response;
                if (res.status === 'success' && res.data) {
                    const user = res.data;

                    $('#editUserModal #userId').val(user.id);
                    $('#editUserModal #username').val(user.username);
                    $('#editUserModal #email').val(user.email);
                    $('#editUserModal #role').val(user.role);
                    $('#editUserModal #status').val(user.status);
                    $('#editUserModal #profilePhotoPreview').attr('src', '/app/' + (user.photo || 'uploads/profile/user-plus.png'));

                    $('#togglePasswordChange').prop('checked', false);
                    $('#passwordFields').hide();
                    $('#newPassword, #confirmPassword').val('');

                    const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                    editModal.show();
                } else {
                    console.error('Edit fetch error:', res.message || 'Unknown error');
                    bootbox.alert('Failed to load user data for editing.');
                }
            } catch (err) {
                console.error('Failed to parse edit data:', err, response);
                bootbox.alert('Failed to load user data for editing.');
            }
        }).fail(function (xhr) {
            console.error('AJAX fetch failed:', xhr.responseText);
            bootbox.alert('Server error while loading user data.');
        });
    });

    // Handle profile photo preview
    $('#profilePhotoInput').on('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#profilePhotoPreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // Toggle password fields
    $('#togglePasswordChange').on('change', function () {
        if (this.checked) {
            $('#passwordFields').slideDown();
        } else {
            $('#passwordFields').slideUp();
            $('#newPassword, #confirmPassword').val('');
        }
    });

    // Handle edit form submission
    $('#editUserForm').submit(function (e) {
  e.preventDefault();

  const form = this;
  const formData = new FormData(form);

  console.log('[Edit Form] Submitting data:', Object.fromEntries(formData.entries()));

  $.ajax({
    url: '../ajax/edit_user.php',
    type: 'POST',
    data: formData,
    contentType: false,
    processData: false,
    dataType: 'json',

    success: function (res) {
      console.log('[Edit Form] Server response:', res);

      if (res.status === 'success' || res.success) {
        bootbox.alert(res.message || 'User updated.', function () {
          const editModal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
          if (editModal) editModal.hide();

          if (typeof window.loadUsers === 'function') {
            window.loadUsers();
          }
        });
      } else {
        console.warn('[Edit Form] Update failed:', res.message);
        bootbox.alert(`<strong>Error:</strong> ${res.message || 'Unknown error occurred.'}`);
      }
    },

    error: function (xhr, status, errorThrown) {
      console.error('[Edit Form] AJAX Error:', {
        status,
        errorThrown,
        response: xhr.responseText
      });

      bootbox.alert(`<strong>Server Error:</strong> ${xhr.status} ${xhr.statusText}<br>${xhr.responseText}`);
    }
  });
});

}
