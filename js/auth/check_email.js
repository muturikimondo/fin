// check_email.js

let emailValid = false;

// Email real-time check
let emailCheckTimeout;
document.getElementById("email").addEventListener("input", () => {
  clearTimeout(emailCheckTimeout);
  emailCheckTimeout = setTimeout(checkEmailAvailability, 500);
});

async function checkEmailAvailability() {
  const email = document.getElementById("email").value.trim();
  if (email === "") return;

  const formData = new FormData();
  formData.append("email", email);

  try {
    const response = await fetch("../ajax/check_email.php", {
      method: "POST",
      body: formData
    });

    const result = await response.json();
    const feedbackEl = getOrCreateEmailFeedback();

    if (result.exists) {
      emailValid = false;
      document.getElementById("email").classList.add("is-invalid");
      document.getElementById("email").classList.remove("is-valid");
      feedbackEl.textContent = "Email is already taken.";
      feedbackEl.classList.add("text-danger");
      feedbackEl.classList.remove("text-success");
    } else {
      emailValid = true;
      document.getElementById("email").classList.remove("is-invalid");
      document.getElementById("email").classList.add("is-valid");
      feedbackEl.textContent = "Email is available.";
      feedbackEl.classList.remove("text-danger");
      feedbackEl.classList.add("text-success");
    }
  } catch (err) {
    console.error("Email check failed:", err);
  }
}

function getOrCreateEmailFeedback() {
  let feedback = document.getElementById("emailFeedback");
  if (!feedback) {
    feedback = document.createElement("div");
    feedback.id = "emailFeedback";
    feedback.className = "form-text mt-1";
    document.getElementById("email").parentElement.appendChild(feedback);
  }
  return feedback;
}
