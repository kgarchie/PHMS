<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="register.css">
</head>
<body>
    <header class = "head">
    <h2>Forgot Password</h2>
    <h3>Please enter your email address to reset your password</h3>
    </header>
    <main>
    <form action="sendpassword_reset.php" method="POST">
        <div class = "input-group">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" placeholder="Enter your username or email" value="<?= htmlspecialchars($_POST["email"] ?? "") ?>"><br><br>
        

        </div>
        
        <div class="input-group">
                <button type="submit" class="btn" name="login_user">Submit</button>
        </div>
    </form>
    </main>
    
</body>
</html>
