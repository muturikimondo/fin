document.addEventListener('DOMContentLoaded', () => {
  const loginForm = document.getElementById('loginForm');
  const loginError = document.getElementById('errorMessage');
  const loginButton = loginForm.querySelector('button[type="submit"]');
  const spinner = document.getElementById('spinner');
  const loginText = document.getElementById('loginText');
  const attemptsCount = document.getElementById('attemptsCount');

  let attemptCounter = 0;

  const showMessage = (message, type = 'danger') => {
    loginError.textContent = message;
    loginError.className = `mt-3 text-center text-${type}`;
    loginError.style.display = 'block';
  };

  const showAttempts = () => {
    attemptCounter++;
    attemptsCount.textContent = `Login attempt: ${attemptCounter}`;
    attemptsCount.style.display = 'block';
  };

  const setFieldValidity = (field, isValid) => {
    if (isValid) {
      field.classList.remove('is-invalid');
    } else {
      field.classList.add('is-invalid');
    }
  };

  const toggleSpinner = (show) => {
    if (show) {
      spinner.classList.remove('d-none');
      loginText.textContent = 'Logging in...';
      loginButton.disabled = true;
    } else {
      spinner.classList.add('d-none');
      loginText.textContent = 'Login';
      loginButton.disabled = false;
    }
  };

  const fetchPost = (url, data) =>
    fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: new URLSearchParams(data).toString()
    }).then(res => res.json());

  if (loginForm) {
    loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      loginError.style.display = 'none';

      const username = loginForm.username.value.trim();
      const password = loginForm.password.value;
      const rememberMe = loginForm.rememberMe?.checked ? 1 : 0;

      // Validate fields
      const validUsername = !!username;
      const validPassword = !!password;
      setFieldValidity(loginForm.username, validUsername);
      setFieldValidity(loginForm.password, validPassword);

      if (!validUsername || !validPassword) {
        showMessage('Both fields are required.');
        showAttempts();
        return;
      }

      try {
        toggleSpinner(true);
        const response = await fetchPost('../ajax/login_process.php', { username, password, rememberMe });

        toggleSpinner(false);

        if (response.success) {
          window.location.href = response.redirect || '../dashboard.php';
        } else {
          showMessage(response.message || 'Login failed.');
          setFieldValidity(loginForm.username, false);
          setFieldValidity(loginForm.password, false);
          showAttempts();
        }
      } catch (err) {
        console.error('Login error:', err);
        toggleSpinner(false);
        showMessage('An unexpected error occurred.');
        showAttempts();
      }
    });
  }

  // Optional: Show/Hide password toggle (if <i> element and span exist)
  const togglePassword = document.getElementById('togglePassword');
  if (togglePassword) {
    togglePassword.addEventListener('click', () => {
      const passwordField = document.getElementById('password');
      const icon = document.getElementById('passwordIcon');
      const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordField.setAttribute('type', type);
      icon.classList.toggle('bi-eye');
      icon.classList.toggle('bi-eye-slash');
    });
  }
});
