<?php
session_start();
// Include database connection file
require_once "server.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reset_password"])) {
    // Get email from the form
    $email = $_POST["email"];

    // Check if email exists in the database
    $sql = "SELECT * FROM accounts WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Generate a unique token
        $token = bin2hex(random_bytes(32));

        // Calculate expiry time (e.g., 30 minutes from now)
        $expiry = date("Y-m-d H:i:s", strtotime('+30 minutes'));

        // Store token hash and expiry in the database
        $token_hash = hash("sha256", $token);
        $sql = "UPDATE accounts SET reset_token_hash = ?, reset_token_expires_at = ? WHERE email = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sss", $token_hash, $expiry, $email);
        $stmt->execute();

        // Close statement
        $stmt->close();

        // Send reset password email using Sendmail (configured in XAMPP)
        $to = $email;
        $subject = "Password Reset Request";
        $message = "Please click the following link to reset your password: http://localhost/resetpassword.php?token=$token";
        $headers = "From: sheeannw@gmail.com"; // Change this to your email address

        // Send email using PHP's mail function
        if (mail($to, $subject, $message, $headers)) {
            $_SESSION['success'] = "Password reset link sent successfully.";
            header("Location: reset_confirmation.php");
            exit();
        } else {
            // Failed to send email
            $_SESSION['error'] = "Failed to send email.";
            header("Location: forgotpassword.php");
            exit();
        }
    } else {
        // Email not found
        $_SESSION['error'] = "Email not found.";
        header("Location: forgotpassword.php");
        exit();
    }
} else {
    // Invalid request
    header("Location: forgotpassword.php");
    exit();
}
?>
