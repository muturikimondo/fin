document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("registerForm");
  const submitBtn = document.getElementById("registerBtn");
  const passwordField = document.getElementById("password");
  const togglePassword = document.getElementById("togglePassword");

  // Live validation on inputs
  ["input", "change"].forEach(evt => {
    form.addEventListener(evt, e => {
      if (e.target.checkValidity()) {
        e.target.classList.remove("is-invalid");
        e.target.classList.add("is-valid");
      } else {
        e.target.classList.remove("is-valid");
        e.target.classList.add("is-invalid");
      }
    }, true);
  });

  // Password toggle functionality
  togglePassword.addEventListener("click", () => {
    const type = passwordField.type === "password" ? "text" : "password";
    passwordField.type = type;
    togglePassword.classList.toggle("bi-eye");
    togglePassword.classList.toggle("bi-eye-slash");
  });

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    // Trigger built-in validation
    if (!form.checkValidity()) {
      e.stopPropagation();
      form.classList.add("was-validated");
      showToast("Please correct errors in the form", "warning");
      return;
    }

    submitBtn.disabled = true;
    submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Registering...`;

    const formData = new FormData(form);

    try {
      const response = await fetch("../ajax/register/register_process.php", {
        method: "POST",
        body: formData
      });

      const result = await response.json();
      if (result.success) {
        showToast(result.message || "Registration successful", "success");
        form.reset();
        form.classList.remove("was-validated");
        document.querySelectorAll(".is-valid").forEach(el => el.classList.remove("is-valid"));
      } else {
        showToast(result.message || "Registration failed", "danger");
      }
    } catch (err) {
      showToast("Something went wrong. Please try again later.", "danger");
    } finally {
      submitBtn.disabled = false;
      submitBtn.innerHTML = `<i class="bi bi-person-plus-fill me-1"></i> Register`;
    }
  });
});

// Toast handler
function showToast(message, type = "info") {
  const toastEl = document.createElement("div");
  toastEl.className = `toast align-items-center text-white bg-${type} border-0 position-fixed bottom-0 end-0 m-3`;
  toastEl.setAttribute("role", "alert");
  toastEl.setAttribute("aria-live", "assertive");
  toastEl.setAttribute("aria-atomic", "true");
  toastEl.style.zIndex = "1055";

  toastEl.innerHTML = `
    <div class="d-flex">
      <div class="toast-body">${message}</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  `;

  document.body.appendChild(toastEl);
  const bsToast = new bootstrap.Toast(toastEl);
  bsToast.show();

  toastEl.addEventListener("hidden.bs.toast", () => {
    toastEl.remove();
  });
}
