<?php
// includes/mailer.php

function sendAdminNotification($username, $email, $role) {
    $to = 'admin@example.com'; // Change to your actual admin email
    $subject = "New User Registration Awaiting Approval";
    $message = "
        A new user has registered:\n\n
        Username: {$username}\n
        Email: {$email}\n
        Role: {$role}\n\n
        Please log in to the admin dashboard to approve or reject this user.
    ";
    $headers = "From: noreply@yourdomain.com\r\n";

    @mail($to, $subject, $message, $headers); // Suppress errors in production
}

