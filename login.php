<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="register.css">
</head>
<body>
  <div class="header">
        <h2>Login</h2>
  </div>
         
  <form method="post" action="login.php">
        <?php include('errors.php'); ?>
        <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter your username" >
        </div>
        <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password">
        </div>
        <div class="remember-me">
            <input type="checkbox" name="remember"> Remember Me
        </div>
        <div class="forgot-password">
            <a href="forgotpassword.php">Forgot Password?</a>
        </div>
        <div class="input-group">
                <button type="submit" class="btn" name="login_user">Login</button>
        </div>
        <p>
                Not yet a member? <a href="register.php" class = "sign-up">Sign up</a>
        </p>
  </form>
</body>
</html>