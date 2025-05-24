<?php
// Register page (auth/register.php)
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>
  
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"/>
  <link rel="stylesheet" href="../css/custom.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
</head>
<body>
  <?php include('../templates/header.php'); ?>

  <div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-lg border-0" style="width: 100%; max-width: 500px; border-radius: 12px;">
      <div class="card-body">
        <h4 class="card-title text-center mb-4">
          <i class="bi bi-person-plus-fill"></i> Register
        </h4>

        <form id="registerForm" enctype="multipart/form-data" novalidate>
          <!-- Logo -->
          <div class="text-center mb-4">
            <img src="../uploads/logo/logo.png" alt="Logo" class="img-fluid" style="max-height: 60px;">
          </div>

          <!-- Username -->
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
              <input type="text" id="username" name="username" class="form-control" required>
              <div class="invalid-feedback">Please enter a username.</div>
            </div>
          </div>

          <!-- Email -->
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
              <input type="email" id="email" name="email" class="form-control" required>
              <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>
          </div>

          <!-- Password and Confirm -->
          <div class="mb-3 row">
            <div class="col-md-6">
              <label for="password" class="form-label">Password</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" id="password" name="password" class="form-control" required minlength="6">
                <div class="invalid-feedback">Min 6 characters required.</div>
              </div>
            </div>
            <div class="col-md-6">
              <label for="confirmPassword" class="form-label">Confirm Password</label>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" required>
                <div class="invalid-feedback">Passwords must match.</div>
              </div>
            </div>
          </div>

          <!-- Role -->
          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person-badge-fill"></i></span>
              <select name="role" id="role" class="form-select">
                <option value="user" selected>User</option>
                <option value="admin">Admin</option>
              </select>
            </div>
          </div>

          <!-- Photo -->
          <div class="mb-3">
            <label for="photo" class="form-label">Profile Photo</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-image-fill"></i></span>
              <input type="file" id="photo" name="photo" class="form-control" accept="image/*">
            </div>
          </div>

          <!-- Submit -->
          <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary px-4" id="registerBtn">
              <span class="spinner-border spinner-border-sm d-none" id="registerSpinner" role="status" aria-hidden="true"></span>
              <span id="registerBtnText"><i class="bi bi-person-plus-fill me-1"></i> Register</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Toast Notifications -->
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
    <div id="registerToast" class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body" id="toastMessage">Registering...</div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  </div>

  <?php include('../templates/footer.php'); ?>

  <script src="../js/auth/index.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
