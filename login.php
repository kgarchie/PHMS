<!DOCTYPE html>
<html lang="en">
<?php include 'partials/head.php'; ?>
<?php
global $errors;
global $db;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    [$result, $error] = value_or_error($db->query("SELECT * FROM users WHERE `email` = ? AND `password` = ?", $email, $password));
    if ($error) return array_push($errors, $error);

    $user = DB::first($result);
    if (!$user) return array_push($errors, "Invalid Email or Password");

    $user_id = DB::getField($user, "id");

    $token = uniqid();
    [$result, $error] = value_or_error($db->query("INSERT INTO sessions (`user_id`, `token`) VALUES (?, ?)", $user_id, $token));
    if ($error) return array_push($errors, $error);

    setAuthCookie($token);
    redirect("/dashboard.php");
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
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="check">
            <label class="form-check-label" for="check">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
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