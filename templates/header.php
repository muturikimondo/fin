<?php
include_once __DIR__ . '/../includes/config.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($page_title) ? htmlspecialchars($page_title) . ' | ' : '' ?><?= htmlspecialchars($site_title) ?></title>

  <!-- Bootstrap & Fonts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

  <!-- Favicon -->
  <link rel="icon" href="<?= asset('uploads/icons/favicon.ico') ?>" type="image/x-icon">

  <!-- Theme CSS Variables -->
  <style>
    :root {
        --primary-color: <?= $brand_colors['primary'] ?>;
        --accent-color: <?= $brand_colors['accent'] ?>;
        --dark-color: <?= $brand_colors['dark'] ?>;
        --beige-color: <?= $brand_colors['beige'] ?>;
        --light-color: <?= $brand_colors['light'] ?>;
    }
  </style>

  <!-- Custom Styles -->
  <link rel="stylesheet" href="<?= asset('css/custom.css') ?>">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="<?= asset('index.php') ?>">
      <img src="<?= asset($logoPath) ?>" alt="Logo" height="30" class="me-2">
      <?= htmlspecialchars($site_title) ?>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php foreach ($nav_items as $item): ?>
          <li class="nav-item">
            <a class="nav-link <?= isActive($item['link']) ?>" href="<?= asset($item['link']) ?>">
              <?= htmlspecialchars($item['label']) ?>
            </a>
          </li>
        <?php endforeach; ?>
        <li class="nav-item d-lg-none">
          <a href="<?= asset('auth/login.php') ?>" class="nav-link text-light">Login</a>
        </li>
        <li class="nav-item d-lg-none">
          <a href="#" class="nav-link text-light" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <i class="bi bi-power logout-icon"></i> Logout
          </a>
        </li>
      </ul>

      <div class="d-none d-lg-flex ms-3">
        <a href="#" title="Logout" class="text-white" data-bs-toggle="modal" data-bs-target="#logoutModal">
          <i class="bi bi-power logout-icon"></i>
        </a>
      </div>
    </div>
  </div>
</nav>

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-sm rounded-3">
      <div class="modal-header bg-light">
        <h5 class="modal-title text-dark">
          <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i> Confirm Logout
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-muted">
        Are you sure you want to logout?
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="<?= asset('auth/logout.php') ?>" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- JS Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootbox@5.5.2/bootbox.min.js" defer></script>
