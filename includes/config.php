<?php
// ----------------------------------------
// Base URL Detection (fixed to /app/)
// ----------------------------------------
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$basePath = '/app/'; // Explicit base directory

define('BASE_URL', $protocol . $host . $basePath);

// Asset helper
function asset($path) {
    return BASE_URL . ltrim($path, '/');
}

// ----------------------------------------
// Branding Details
// ----------------------------------------
$site_title = "Laikipia County Finance Portal";
$site_tagline = "Empowering Financial Accountability and Transparency";
$cta_button_text = "Visit the Website";
$cta_button_link = "https://laikipia.go.ke";
$chief_officer_email = 'jgatweku@gmail.com';

// ----------------------------------------
// Logo & Colors
// ----------------------------------------
$logoPath = 'uploads/logo/logo.png';

$brand_colors = [
    'primary' => '#00632d',
    'accent'  => '#02a554',
    'dark'    => '#432d14',
    'beige'   => '#c2aa8d',
    'light'   => '#f2e1d7'
];

// ----------------------------------------
// Navigation
// ----------------------------------------
$nav_items = [
    ['label' => 'Home',   'link' => 'index.php'],
    ['label' => 'Login',  'link' => 'auth/login.php'],
    ['label' => 'Help',   'link' => '#'],
    ['label' => 'FAQ',    'link' => '#'],
    ['label' => 'Contact','link' => '#']
];

// ----------------------------------------
// Active Nav Link Helper
// ----------------------------------------
function isActive($link) {
    $current = $_SERVER['PHP_SELF'];
    return strpos($current, $link) !== false ? 'active' : '';
}
?>
