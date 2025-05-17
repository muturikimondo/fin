<?php include '../templates/header.php'; ?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
      <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-5">

          <!-- Logo -->
          <div class="text-center mb-4">
            <img src="<?= htmlspecialchars($logoPath) ?>"
                 alt="<?= htmlspecialchars($site_title) ?> Logo"
                 class="img-fluid"
                 style="max-height: 80px;">
          </div>

          <!-- Heading -->
          <h3 class="text-center mb-4" style="color: #00632d;">Login to Your Account</h3>

          <!-- Login Form -->
          <form id="loginForm" novalidate>
            <!-- Username/Email -->
            <div class="mb-3">
              <label for="username" class="form-label">Username or Email</label>
              <input type="text"
                     class="form-control"
                     id="username"
                     name="username"
                     placeholder="Enter your username or email"
                     required>
              <div class="invalid-feedback">Please enter your username or email.</div>
            </div>

            <!-- Password with toggle -->
            <div class="mb-3 position-relative">
              <label for="password" class="form-label">Password</label>
              <input type="password"
                     class="form-control"
                     id="password"
                     name="password"
                     placeholder="Enter your password"
                     required>
              <span id="togglePassword"
                    class="position-absolute top-50 end-0 translate-middle-y pe-3"
                    style="cursor: pointer;">
                <i class="bi bi-eye-slash" id="passwordIcon"></i>
              </span>
              <div class="invalid-feedback">Please enter your password.</div>
            </div>

            <!-- Remember Me -->
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="rememberMe">
              <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>

            <!-- Submit Button with Spinner -->
            <button type="submit" class="btn btn-success w-100 shadow-sm rounded-pill d-flex justify-content-center align-items-center gap-2">
              <span id="loginText">Login</span>
              <div id="spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></div>
            </button>
          </form>

          <!-- Error Message -->
          <div id="errorMessage" class="mt-3 text-danger text-center" style="display: none;"></div>

          <!-- Attempt Count -->
          <div id="attemptsCount" class="text-center mt-2 text-muted small" style="display: none;"></div>

          <!-- Forgot Password Link -->
          <div class="text-center mt-3">
            <a href="#" style="color: #00632d; text-decoration: none; font-weight: 600;">
              Forgot Password?
            </a>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../templates/footer.php'; ?>
<script src="../js/login.js"></script>
