// index.js

// Import the register.js functionality
import './register.js';

// Import the check_email.js functionality
import './check_email.js';

// index.js (Service for register.js, check_email.js, and imagePreview.js)

document.addEventListener("DOMContentLoaded", () => {
  // Dynamically load the imagePreview.js script to enable image preview functionality
  const script = document.createElement('script');
  script.src = './image_preview.js'; // Update with the correct path to the imagePreview.js file
  document.body.appendChild(script);

  // You can also include register.js and check_email.js similarly if needed
});

