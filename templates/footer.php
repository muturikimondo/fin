<!-- templates/footer.php -->
<footer id="appFooter" class="bg-dark text-light text-center py-4 mt-5" style="position: relative; width: 100%; border-top: 1px solid #444;">
    <div class="container">
        <!-- Footer Top Section (Brand & Rights) -->
        <div class="row">
            <div class="col-12">
                <p class="mb-0">
                    &copy; <?= date('Y') ?> <strong><?= htmlspecialchars($site_title) ?></strong>. All rights reserved.
                </p>
                <small class="text-muted">Powered by <span class="fw-bold">Laikipia County Treasury ICT</span></small>
            </div>
        </div>

        <!-- Footer Social Icons Section -->
        <div class="row justify-content-center my-3">
            <div class="col-auto">
                <a href="https://facebook.com" target="_blank" class="social-icon text-light me-3" title="Facebook">
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="https://twitter.com" target="_blank" class="social-icon text-light me-3" title="Twitter">
                    <i class="bi bi-twitter"></i>
                </a>
                <a href="https://instagram.com" target="_blank" class="social-icon text-light me-3" title="Instagram">
                    <i class="bi bi-instagram"></i>
                </a>
                <a href="https://linkedin.com" target="_blank" class="social-icon text-light" title="LinkedIn">
                    <i class="bi bi-linkedin"></i>
                </a>
            </div>
        </div>

        <!-- Footer Bottom Section (Legal and Contact) -->
        <div class="row">
            <div class="col-12">
                <small class="text-muted">
                    <a href="/privacy-policy" class="text-light" style="text-decoration: none;">Privacy Policy</a> | 
                    <a href="/terms" class="text-light" style="text-decoration: none;">Terms & Conditions</a>
                </small>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap 5.3 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Optional Custom JS -->
