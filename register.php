<!doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php' ?>
<?php
global $errors;
global $db;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    [$result, $error] = value_or_error($db->query("INSERT INTO users (`name`, `email`, `password`) VALUES (?, ?, ?)", $name, $email, $password));
    if ($error) return array_push($errors, $error);

    $user = DB::first($result);
    if (!$user) return array_push($errors, "Unknown Error Occurred");

    $token = uniqid();
    [$result, $error] = value_or_error($db->query("INSERT INTO sessions (`user_id`, `token`) VALUES (?, ?)", DB::getField($user, "id"), $token));
    if ($error) return array_push($errors, $error);

    setAuthCookie($token);
    redirect("/dashboard.php");
}
?>
<main class="container">
    <form action="register.php" method="POST" class="w-50 mx-auto mt-5 shadow-sm p-4 rounded" id="register-form">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" aria-describedby="usernameHelp" name="username" autocomplete="username">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" autocomplete="email">
            <small id="emailHelp" class="form-text">We'll never share your email with anyone else.</small>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="check">
            <label class="form-check-label" for="check">Agree to the terms and conditions</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
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