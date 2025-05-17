<?php
// templates/header.php
include_once __DIR__ . '/../includes/config.php';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($page_title) ? htmlspecialchars($page_title) . ' | ' : '' ?><?= htmlspecialchars($site_title) ?></title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Favicon and Custom Styles -->
  <link rel="icon" href="../uploads/icons/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="../css/custom.css">

  <style>
    :root {
      --primary-color: <?= $brand_colors['primary'] ?>;
      --accent-color: <?= $brand_colors['accent'] ?>;
      --dark-color: <?= $brand_colors['dark'] ?>;
      --beige-color: <?= $brand_colors['beige'] ?>;
      --light-color: <?= $brand_colors['light'] ?>;
    }

    body {
      background-color: var(--light-color);
      font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .navbar {
      background-color: var(--primary-color);
      border-bottom: 2px solid var(--accent-color);
    }

    .navbar .nav-link,
    .navbar-brand {
      color: #fff;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .navbar .nav-link:hover {
      color: var(--accent-color);
    }

    .logout-icon {
      color: #fff;
      font-size: 1.2rem;
      transition: transform 0.2s;
    }

    .logout-icon:hover {
      color: #dc3545;
      transform: scale(1.1);
    }

    .nav-link.active {
      color: var(--accent-color);
      font-weight: 700;
    }
  </style>

  <!-- jQuery & Bootbox -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/bootbox@5.5.2/bootbox.min.js" defer></script>
</head>

<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg" aria-label="Main navigation">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="../index.php">
      <img src="../uploads/logo/logo.png" alt="Logo" height="30" class="me-2">
      <?= htmlspecialchars($site_title) ?>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php foreach ($nav_items as $item): ?>
          <li class="nav-item">
            <a class="nav-link <?= basename($_SERVER['PHP_SELF']) === $item['link'] ? 'active' : '' ?>"
               href="../<?= htmlspecialchars($item['link']) ?>">
              <?= htmlspecialchars($item['label']) ?>
            </a>
          </li>
        <?php endforeach; ?>

        <!-- Mobile View Auth Links -->
        <li class="nav-item d-lg-none">
          <a href="../auth/login.php" class="nav-link text-light">Login</a>
        </li>
        <li class="nav-item d-lg-none">
          <a href="#" class="nav-link text-light" data-bs-toggle="modal" data-bs-target="#logoutModal">
            <i class="bi bi-power logout-icon"></i> Logout
          </a>
        </li>
      </ul>

      <!-- Desktop Logout Icon -->
      <div class="d-none d-lg-flex ms-3 align-items-center">
        <a href="#" title="Logout" class="text-white" data-bs-toggle="modal" data-bs-target="#logoutModal">
          <i class="bi bi-power logout-icon"></i>
        </a>
      </div>
    </div>
  </div>
</nav>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-sm rounded-3">
      <div class="modal-header bg-light">
        <h5 class="modal-title text-dark" id="logoutModalLabel">
          <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i> Confirm Logout
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-muted">
        Are you sure you want to logout? Your session will be ended.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
