// js/utils.js

/**
 * Displays a styled Bootstrap message on a given DOM element.
 * @param {HTMLElement} el - Element to display the message in.
 * @param {string} message - The message to show.
 * @param {string} type - Bootstrap alert color (e.g. 'success', 'danger').
 */
export const showMessage = (el, message, type = 'danger') => {
  el.textContent = message;
  el.className = `mt-3 text-center fw-bold text-${type}`;
};

/**
 * Toggles a spinner inside a button and disables/enables the button.
 * @param {HTMLButtonElement} btn - Button containing a spinner.
 * @param {boolean} show - Whether to show the spinner.
 */
export const toggleSpinner = (btn, show = true) => {
  const spinner = btn.querySelector('.spinner-border');
  btn.disabled = show;
  if (spinner) spinner.classList.toggle('d-none', !show);
};

/**
 * POSTs data to a URL and expects a JSON response.
 * @param {string} url - Endpoint URL.
 * @param {object|FormData} data - Payload to send.
 * @param {boolean} isFormData - Whether the payload is FormData.
 * @returns {Promise<object>} - Parsed JSON response.
 */
export const fetchPost = (url, data, isFormData = false) =>
  fetch(url, {
    method: 'POST',
    headers: isFormData ? undefined : { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: isFormData ? data : new URLSearchParams(data).toString()
  })
    .then(async res => {
      const text = await res.text();
      try {
        return JSON.parse(text);
      } catch (err) {
        console.error('Invalid JSON:', text);
        throw new Error('Invalid JSON response');
      }
    });

/**
 * Global JS error logger for development.
 */
window.addEventListener('error', (e) => {
  console.error('Global JS Error:', e.message, 'at', `${e.filename}:${e.lineno}`);
});
