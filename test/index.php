

<?php
//include '../templates/header.php';

?>

<div class="container-fluid mt-4">
  <h3 class="mb-4 text-dark fw-bold">
    <i class="bi bi-people-fill me-2"></i>User Management
  </h3>

  <!-- Filters Section -->
  <div class="row g-3 mb-4">
    <div class="col-12 col-sm-6 col-md-3">
      <input type="text" id="searchName" class="form-control" placeholder="Search by Name">
    </div>
    <div class="col-12 col-sm-6 col-md-3">
      <input type="email" id="searchEmail" class="form-control" placeholder="Search by Email">
    </div>
    <div class="col-6 col-md-2">
      <select id="filterRole" class="form-select">
        <option value="">All Roles</option>
        <option value="admin">Admin</option>
        <option value="co">Coordinator</option>
        <option value="user">User</option>
      </select>
    </div>
    <div class="col-6 col-md-2">
      <select id="filterStatus" class="form-select">
        <option value="">All Statuses</option>
        <option value="approved">Approved</option>
        <option value="pending">Pending</option>
        <option value="rejected">Rejected</option>
      </select>
    </div>
    <div class="col-12 col-md-2 text-end">
      <button id="clearFilters" class="btn btn-outline-secondary w-100">Clear Filters</button>
    </div>
  </div>

  <!-- User Table Grid Inside a Single Card -->
  <div class="card border" id="usersGrid">
    <div class="card-body">
      <!-- Table Header (Static) -->
      <div class="row fw-bold border-bottom pb-2 mb-3">
        <div class="col-12 col-md-1">Photo</div>
        <div class="col-12 col-md-1">Username</div>
        <div class="col-12 col-md-2">Email</div>
        <div class="col-12 col-md-1">Role</div>
        <div class="col-12 col-md-1">Status</div>
        <div class="col-12 col-md-1">Login Count</div>
        <div class="col-12 col-md-2">Last Login</div>
        <div class="col-12 col-md-2">Created At</div>
        <div class="col-12 col-md-1">Actions</div>
      </div>

      <!-- Dynamic User Rows Will Be Injected Here -->
      <div id="usersTableBody">
        <!-- JavaScript will dynamically inject user rows here -->
      </div>

      <!-- Pagination Controls -->
      <div id="paginationControls" class="d-flex justify-content-center mt-4">
        <button id="previousPage" class="btn btn-outline-primary btn-sm mx-1" title="Previous">
          <i class="bi bi-chevron-left"></i>
        </button>

        <!-- Page Buttons -->
        <div id="paginationButtons" class="d-flex align-items-center mx-2">
          <!-- Page buttons will be inserted dynamically here -->
        </div>

        <button id="nextPage" class="btn btn-outline-primary btn-sm mx-1" title="Next">
          <i class="bi bi-chevron-right"></i>
        </button>
      </div>

      <!-- Pagination Summary -->
      <div id="paginationSummary" class="text-center mt-2">
        <small class="text-muted">Page <span id="currentPageNumber">1</span> of <span id="totalPages">1</span></small>
      </div>

    </div>
  </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <form id="editUserForm" enctype="multipart/form-data">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="userId" id="userId">

          <!-- Profile photo and form fields -->
          <div class="row mb-3 align-items-center">
            <div class="col-md-3 text-center">
              <img id="profilePhotoPreview" src="/app/uploads/profile/user-plus.png"
                   alt="Profile Photo" class="img-thumbnail rounded-circle"
                   style="width: 100px; height: 100px; object-fit: cover;">
              <input type="file" class="form-control mt-2" name="photo" id="profilePhotoInput" accept="image/*">
            </div>

            <div class="col-md-9">
              <div class="row g-3">
                <div class="col-md-6">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="col-md-6">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" required>
                </div>
              </div>

              <div class="row g-3 mt-2">
                <div class="col-md-6">
                  <label for="role" class="form-label">Role</label>
                  <select class="form-select" id="role" name="role" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                    <option value="co">Chief Officer</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="status" class="form-label">Status</label>
                  <select class="form-select" id="status" name="status" required>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <hr>

          <!-- Password change toggle -->
          <div class="form-check mb-2">
            <input type="checkbox" class="form-check-input" id="togglePasswordChange">
            <label class="form-check-label" for="togglePasswordChange">Change Password</label>
          </div>

          <!-- Password fields -->
          <div id="passwordFields" class="row g-3 mb-3" style="display: none;">
            <div class="col-md-6">
              <label for="newPassword" class="form-label">New Password</label>
              <input type="password" class="form-control" name="newPassword" id="newPassword" minlength="6">
            </div>
            <div class="col-md-6">
              <label for="confirmPassword" class="form-label">Confirm Password</label>
              <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" minlength="6">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Save Changes
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="bi bi-x-circle"></i> Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php
//include '../templates/footer.php';
?>

<!-- Dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootbox@5.5.2/bootbox.min.js"></script>

<!-- Your custom script -->
<script type="module" src="/app/js/users/index.js"></script>

