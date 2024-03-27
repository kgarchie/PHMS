<!DOCTYPE html>
<html lang="en">
<?php include 'partials/head.php'; ?>

<body>
    <?php include 'partials/header.php' ?>
    <?php global $errors, $mail;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            $token = generateToken($email);
            $origin = getOrigin();

            if ($token) {
                $body = "Click <a href='$origin/update-password.php?token=$token'>here</a> to reset your password";
                [$success, $error] = $mail->send($email, "Password Reset", $body);

                if ($success) {
                    redirect("success-password-request.php");
                } else {
                    array_push($errors, $error);
                }
            }
        } else {
            array_push($errors, "Please fill in all fields");
        }
    }
    ?>
    <main class="container">
        <form action="request-password-reset.php" method="POST" class="w-50 mx-auto mt-5 shadow-sm p-4 rounded" id="reset-form">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email">
                <div id="emailHelp" class="form-text">Enter the email address you used for sign up, a password request link
                    will be sent there
                </div>
            </div>
            <div class="btn-group d-flex">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a class="btn btn-outline-secondary" href="/">Cancel</a>
            </div>
            <small class="text-muted">Don't have an account? <a href="/register.php">Sign Up</a></small>
            <script>
                const form = document.querySelector('#reset-form');
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const email = form.querySelector('#email').value;
                    if (!email) {
                        alert('Please fill in all fields');
                        return;
                    }
                    form.submit();
                });
            </script>
        </form>
    </main>
    <?php include "partials/footer.php" ?>
</body>

</html>