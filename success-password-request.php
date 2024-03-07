<!doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php' ?>
<?php global $errors, $db, $mail; ?>
<!----------------------------------------------------------------------------------->
<?php
// Write your php code here
?>
<main>
    <div class="container">
        <div class="alert alert-success mt-5" role="alert">
            Password reset link has been sent to your email,
            <br/>
            You will be redirected to the login page in <span id="seconds">3 seconds</span>.
            <br/>
            <small class="text-muted">Didn't receive the email? Check your spam folder</small>
            <br/>
            <small class="text-muted">Login <a href="/login.php">here</a></small>
        </div>
    </div>
    <script>
        let seconds = 3;
        setInterval(() => {
            seconds--;
            document.querySelector('#seconds').innerText = seconds + " seconds";
        }, 1000);
        setTimeout(() => {
            window.location.href = '/login.php';
        }, 3500);
    </script>
    <style>
        #seconds{
            font-weight: bold;
        }
    </style>
</main>

<!---------------------------------------------------------------------------------->
<?php include 'partials/footer.php'; ?>
</body>
</html>