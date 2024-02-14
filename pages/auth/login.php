<?php global $db;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        array_push($errors, "Email and password are required");
        return;
    }

    $user = $db->query("SELECT * FROM users WHERE email = ? AND password = ?", $email, $password);

    if ($user) {
        $cookie = $user['id'] . ":" . $user['email'];
        $expire = time() + 60 * 60 * 24 * 30;
        setcookie("user", $cookie, $expire, "/");
        redirect("home");
    } else {
        array_push($errors, "Invalid email or password");
    }
}
?>
<section class="container">
    <form class="box login" method="post">
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
                <input class="input" type="password" placeholder="Password" autocomplete="current-password" name="password">
                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                </span>
            </p>
        </div>
        <small class="help">Don't have an account? <a href="/auth/register">Register</a></small>
        <style>
            small.help {
                display: block;
                margin-bottom: 5px;
            }
        </style>
        <div class="field">
            <p class="control">
                <button class="button is-success">
                    Login
                </button>
            </p>
        </div>
    </form>
    <style>
        form.login {
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
</section>