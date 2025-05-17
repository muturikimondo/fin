<div class="container-fluid mt-4">
  <h3 class="mb-4 text-dark fw-bold">
    <i class="bi bi-people-fill me-2"></i>User Management
  </h3>

  <!-- Filters -->
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
        <div class="col-12 col-md-2">Username</div>
        <div class="col-12 col-md-3">Email</div>
        <div class="col-12 col-md-2">Role</div>
        <div class="col-12 col-md-2">Status</div>
        <div class="col-12 col-md-3">Actions</div>
      </div>

      <!-- Dynamic User Rows Will Be Injected Here -->
      <div id="usersTableBody">
        <!-- JavaScript will dynamically inject user rows here -->
      </div>

    </div>
  </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editUserForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editUserLabel">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="userId" name="update_user_id">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" id="username" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" required>
          </div>
          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" id="role" class="form-select">
              <option value="admin">Admin</option>
              <option value="co">Coordinator</option>
              <option value="user">User</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
              <option value="approved">Approved</option>
              <option value="pending">Pending</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>
        </div>
       <div class="modal-footer">
    <button type="submit" class="btn btn-outline-success btn-sm" title="Save Changes">
        <i class="bi bi-check-circle-fill"></i> <!-- Green Tick Icon -->
    </button>
    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" title="Cancel">
        <i class="bi bi-x-circle-fill"></i> <!-- Red Cross Icon -->
    </button>
</div>


      </div>
    </form>
  </div>
</div>

<!-- Dependencies -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootbox@5.5.2/bootbox.min.js"></script>

<!-- Your custom script -->
<script src="../js/users_action.js"></script>



