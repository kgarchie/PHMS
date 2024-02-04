<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>

<h2>Login</h2>

<?php
// Check if the user has submitted the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Credentials for authentication
    $username = "admin";
    $password = "password";
    $email = "admin@example.com";

    // Retrieve user input from the login form
    $input_username = $_POST["username"];
    $input_password = $_POST["password"];
    $input_email = $_POST["email"];

    // Check if the input credentials match the predefined credentials
    if ($input_username === $username && $input_password === $password && $input_email === $email) {
        // If the credentials match, redirect the user to a welcome page
        header("Location: welcome.php");
        exit;
    } else {
        // If the credentials do not match, display an error message
        echo "<p>Invalid username, email, or password. Please try again.</p>";
    }
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <input type="submit" value="Login">
    </div>
</form>

</body>
</html>
