<!doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>

<body>
    <?php include 'partials/header.php' ?>
    <?php
    global $errors;
    global $db;

    function createUser($name, $email, $password)
    {
        global $errors, $db;
        [$result, $error] = $db->query("INSERT INTO users (`name`, `email`, `password`) VALUES (?, ?, ?)", $name, strtolower($email), password_hash($password, PASSWORD_DEFAULT));
        if ($error) {
            array_push($errors, $error);
            return null;
        }

        return $result;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            if(!isset($_POST['name'])) {
                $name = explode('@', $_POST['email'])[0];
            } else {
                $name = $_POST['name'];
            }
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = createUser($name, $email, $password);
            $token = authenticate($email, $password);
            if ($token && $user) {
                setAuthCookie($token);
                redirect("/dashboard.php");
            }
        } else {
            array_push($errors, "Please fill in all fields");
        }
    }
    ?>
    <main class="container">
        <form action="register.php" method="POST" class="w-50 mx-auto mt-5 shadow-sm p-4 rounded" id="register-form">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" aria-describedby="usernameHelp" name="name" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" autocomplete="email">
                <small id="emailHelp" class="form-text">We'll never share your email with anyone else.</small>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" autocomplete="password">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="check">
                <label class="form-check-label" for="check">Agree to the terms and conditions</label>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-primary d-inline-block">Submit</button>
                <small class="text-muted">Already have an account? <a href="/login.php">Login</a></small>
            </div>
            <script>
                const form = document.querySelector('#register-form');
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    const username = form.querySelector('#username').value;
                    const email = form.querySelector('#email').value;
                    const password = form.querySelector('#password').value;
                    const check = form.querySelector('#check').checked;
                    if (!username || !email || !password || !check) {
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