// index.js
import { loadUsers } from './fetch_users.js';
import { renderPagination } from './pagination.js';
import { bindFilters } from './filters.js';
import { bindDeleteUser } from './deleteUser.js';
import { bindEditUser } from './editUser.js';

// Define setLoadUsersRef function if you want to keep the reference
function setLoadUsersRef(fn) {
    window.loadUsers = fn;
}

// Initialize everything on document ready
$(document).ready(function () {
    setLoadUsersRef(loadUsers);  // Set global reference to loadUsers

    window.currentPage = 1;  // Initial page
    loadUsers();  // Initial load
    bindFilters();  // Setup filtering
    bindDeleteUser();  // Setup delete logic
    bindEditUser();  // Setup edit logic
});
