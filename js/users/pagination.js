export function renderPagination(currentPage, total, pageSize, onPageChange) {
    const totalPages = Math.ceil(total / pageSize);
    const pagination = $('#paginationControls');
    pagination.empty();

    if (totalPages <= 1) return;

    const firstBtn = $('<button class="btn btn-sm btn-outline-primary me-1">First</button>');
    const prevBtn = $('<button class="btn btn-sm btn-outline-primary me-1">Previous</button>');

    if (currentPage === 1) {
        firstBtn.prop('disabled', true);
        prevBtn.prop('disabled', true);
    }

    firstBtn.on('click', () => onPageChange(1));
    prevBtn.on('click', () => { if (currentPage > 1) onPageChange(currentPage - 1); });

    pagination.append(firstBtn, prevBtn);

    for (let i = 1; i <= totalPages; i++) {
        const btn = $(`<button class="btn btn-sm ${i === currentPage ? 'btn-primary' : 'btn-outline-primary'} me-1">${i}</button>`);
        btn.on('click', () => onPageChange(i));
        pagination.append(btn);
    }

    const nextBtn = $('<button class="btn btn-sm btn-outline-primary me-1">Next</button>');
    const lastBtn = $('<button class="btn btn-sm btn-outline-primary me-1">Last</button>');

    if (currentPage === totalPages) {
        nextBtn.prop('disabled', true);
        lastBtn.prop('disabled', true);
    }

    nextBtn.on('click', () => { if (currentPage < totalPages) onPageChange(currentPage + 1); });
    lastBtn.on('click', () => onPageChange(totalPages));

    pagination.append(nextBtn, lastBtn);
}
