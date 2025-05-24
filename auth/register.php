<?php
// Include the header and DB connection
require_once('../templates/header.php');
require_once('../includes/db.php');
?>

<div class="container mt-5">



<!-- Access Warning Alert -->
<div class="container mt-4">
  <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center shadow-sm border-start border-4 border-warning" role="alert">
 <strong>Notice:</strong> This is not a public page. Users are advised that registration and use of the system is subject to  <strong> Chief Officer’s approval</strong>.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
</div>






<style>


/* Custom Styles for the Registration Form */


/* Card Style */
.card {
  border-radius: 15px; /* Rounded corners for the card */
  background: #fff; /* White background */
  box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
  transition: all 0.3s ease-in-out; /* Smooth transition for hover effect */
}

/* Hover effect for card */
.card:hover {
  transform: translateY(-10px); /* Slightly lift the card */
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.15); /* Increase shadow on hover */
}

/* Card Body Padding */
.card-body {
  padding: 30px;
}

/* Form Heading */
h2 {
  font-size: 2rem;
  font-weight: 600;
  color: #333; /* Dark text color */
}

/* Inputs and Select Styling */
.form-control, .form-select {
  border-radius: 10px; /* Rounded corners for input fields */
  padding: 15px 20px; /* Spacious padding for inputs */
  border: 1px solid #ddd; /* Light border for inputs */
  transition: all 0.3s ease; /* Transition for input focus effect */
}

.form-control:focus, .form-select:focus {
  border-color: #0056b3; /* Change border color when focused */
  box-shadow: 0 0 5px rgba(0, 86, 179, 0.5); /* Subtle blue shadow on focus */
}

/* Input Group for Password */
.input-group {
  position: relative;
}

#togglePassword {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  background: transparent;
  border: none;
  cursor: pointer;
}

#eyeIcon {
  font-size: 1.2rem;
  color: #6c757d;
}

#togglePassword:hover #eyeIcon {
  color: #0056b3;
}

/* Form Labels */
.form-label {
  font-weight: 500;
  color: #555; /* Lighter text color for labels */
}

/* Submit Button */
button#registerBtn {
  padding: 12px 30px;
  border-radius: 30px; /* Rounded button */
  font-size: 1rem;
  background-color: #007bff; /* Primary blue background */
  border: none;
  color: white;
  box-shadow: 0 5px 15px rgba(0, 123, 255, 0.2);
  transition: all 0.3s ease-in-out; /* Button hover effect */
}

button#registerBtn:hover {
  background-color: #0056b3; /* Darker blue on hover */
  box-shadow: 0 6px 18px rgba(0, 86, 179, 0.3); /* Enhanced shadow on hover */
}

/* Help Text Style */
#passwordHelp {
  font-size: 0.9rem;
  color: #888; /* Lighter text for password guidelines */
  margin-top: 5px;
}

/* Responsive Styles */
@media (max-width: 768px) {
  .card {
    margin: 20px;
  }

  .form-control, .form-select {
    font-size: 1rem; /* Ensure inputs are still easy to read on small screens */
  }

  button#registerBtn {
    font-size: 1.1rem;
    padding: 10px 25px; /* Adjust button padding for smaller screens */
  }
}






.input-group {
    position: relative;
}

#togglePassword {
    border: none;
    background-color: transparent;
    cursor: pointer;
}

#eyeIcon {
    font-size: 1.2rem;
}
</style>

    <div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow rounded-4 border-0">
        <div class="card-body p-4">
          <div class="text-center mb-4 d-flex justify-content-center align-items-center gap-2 flex-wrap">
  <img src="../uploads/logo/logo.png" alt="Logo" style="height: 48px; width: auto;" class="img-fluid">
  <h2 class="mb-0">Create an Account</h2>
</div>


          <!-- Registration Form -->
          <form id="registerForm" enctype="multipart/form-data" novalidate>
            <!-- Username -->
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <!-- Password -->
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <div class="input-group">
                <input type="password" class="form-control" id="password" name="password" required minlength="8"
                  pattern="^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                  placeholder="Enter your password">
                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                  <i class="bi bi-eye-slash" id="eyeIcon"></i>
                </button>
              </div>
              <div id="passwordHelp" class="form-text">
                Your password must be at least 8 characters long, contain at least one letter, one number, and one special character.
              </div>
            </div>

            <!-- Role -->
            <div class="mb-3">
              <label for="role" class="form-label">Role</label>
              <select class="form-select" id="role" name="role">
                <option value="user" selected>User</option>
                <option value="admin">Admin</option>
                <option value="co">Chief Officer</option>
                <option value="dir">Director</option>
                <option value="po">Procurement Officer</option>
                <option value="acc">Accountant</option>
              </select>
            </div>

            <!-- Profile Photo -->
             <div class="mb-3">
    <label for="photo" class="form-label">Profile Photo</label>
    <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
    <img id="photoPreview" src="" alt="Photo Preview" style="display: none; max-width: 200px; margin-top: 10px;">
  </div>

            <!-- Submit Button -->
            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-primary" id="registerBtn">
                <i class="bi bi-person-plus-fill me-1"></i> Register
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


    <!-- Toast Notification Area -->
    <div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
        <!-- Toasts will appear here -->
    </div>
</div>

<?php
// Include the footer
require_once('../templates/footer.php');
?>

<!-- JavaScript Files -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.js"></script>

<script type="module" src="../js/auth/index.js"></script>
