<?php
require_once 'mail/Mail.php';
global $mail;
[$success, $error] = $mail->send('archiethebig@gmail.com', 'Test', 'This is a test email from PHMS');

if ($success) {
    echo "Email sent successfully";
} else {
    echo "Failed to send email: $error";
}