<!DOCTYPE html>
<html lang="en">
<?php include 'partials/head.php'; ?>
<?php
global $errors;
global $db;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $token = authenticate($email, $password);
    if ($token) {
        setAuthCookie($token);
        redirect("/dashboard.php");
    }
}
?>
<body>
<?php include 'partials/header.php'; ?>
<main class="container">
    <form action="login.php" method="POST" class="w-50 mx-auto mt-5 shadow-sm p-4 rounded" id="login-form">
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3 position-relative">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
            <small class="text-muted position-absolute end-0">Forgot Password? <a href="/request-password-reset.php">Reset</a></small>
        </div>
        <div class="btn-group d-block">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <small class="text-muted">Don't have an account? <a href="/register.php">Sign Up</a></small>
        <script>
            const form = document.querySelector('#login-form');
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                const email = form.querySelector('#email').value;
                const password = form.querySelector('#password').value;
                if (!email || !password) {
                    alert('Please fill in all fields');
                    return;
                }
                form.submit();
            });
        </script>
    </form>
</main>
<?php include 'partials/footer.php'; ?>
</body>

</html>