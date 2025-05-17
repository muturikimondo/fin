<?php
// templates/hero.php
?>
<section class="hero-section d-flex align-items-center justify-content-center text-center text-white" style="background: url('uploads/bg.jpg') center center/cover no-repeat; height: 600px; position: relative;">
    <div class="overlay" style="position: absolute; top:0; left:0; width:100%; height:100%; background-color: rgba(0, 99, 45, 0.6);"></div>
    
    <div class="container position-relative" style="z-index: 2;">
        <h1 class="display-4 fw-bold">Welcome to <?= htmlspecialchars($site_title) ?></h1>
        <p class="lead mb-4">Empowering Financial Accountability, Transparency and Growth</p>
        <a href="https://www.laikipia.go.ke" target="_blank" class="btn btn-lg btn-success px-4 rounded-pill">
            Visit Laikipia Website
        </a>
    </div>
</section>

