<?php global $db;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        array_push($errors, "Email and password are required");
        return;
    }

    if(empty($username)){
        $username = ucfirst(explode('@', $email)[0]);
    }

    try {
        $db->query("INSERT INTO users (name, email, password) VALUES ('$username', '$email', '$password')");
        redirect("auth/login");
    } catch (Exception $e) {
        array_push($errors, $e->getMessage());
    }
}
?>
<section class="container">
    <h1 class="heading has-text-centered" style="font-size: 1.125rem; font-weight: bold">Register</h1>
    <form class="box register" method="post">
        <div class="field">
            <p class="control has-icons-left has-icons-right">
                <label class="label">Username</label>
                <input class="input" type="text" placeholder="Username (optional)" name="username"
                       autocomplete="off">
                <span class=" icon is-small is-left">
                <i class="fas fa-envelope"></i>
                </span>
                <span class="icon is-small is-right">
                    <i class="fas fa-check"></i>
                </span>
            </p>
        </div>
        <div class="field">
            <p class="control has-icons-left has-icons-right">
                <label class="label">Email</label>
                <input class="input" type="email" placeholder="Email" autocomplete="email" name="email">
                <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                </span>
                <span class="icon is-small is-right">
                    <i class="fas fa-check"></i>
                </span>
            </p>
        </div>
        <div class="field">
            <p class="control has-icons-left">
                <label class="label">Password</label>
                <input class="input" type="password" placeholder="Password" autocomplete="new-password" name="password">
                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                </span>
            </p>
        </div>
        <small class="help">Don't have an account? <a href="/auth/login">Log In</a></small>
        <style>
            small.help {
                display: block;
                margin-bottom: 5px;
            }
        </style>
        <div class="field">
            <p class="control">
                <button class="button is-success">
                    Sign Up
                </button>
            </p>
        </div>
    </form>
    <style>
        form.register {
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
</section>
