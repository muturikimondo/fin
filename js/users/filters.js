// Function to bind filter events
export function bindFilters() {
    // Filter change
    $('#searchName, #searchEmail, #filterRole, #filterStatus').on('input change', function () {
        const filters = {
            name: $('#searchName').val(),
            email: $('#searchEmail').val(),
            role: $('#filterRole').val(),
            status: $('#filterStatus').val()
        };
        window.currentPage = 1; // Reset to the first page when applying filters
        window.loadUsers(filters); // Load users with new filters
    });

    // Clear filters
    $('#clearFilters').on('click', function () {
        $('#searchName, #searchEmail, #filterRole, #filterStatus').val('');
        window.currentPage = 1; // Reset to the first page
        window.loadUsers(); // Load users without filters
    });
}
