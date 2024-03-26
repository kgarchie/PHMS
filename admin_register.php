<!Doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php' ?>
<?php global $errors, $db, $mail; ?>
<!----------------------------------------------------------------------------------->
<?php
function createAdmin($name, $email, $password)
{
    global $errors, $db;
    [$result, $error] = $db->query("INSERT INTO users (`name`, `email`, `password`, `role`) VALUES (?, ?, ?, ?)", $name, strtolower($email), password_hash($password, PASSWORD_DEFAULT), 'admin');
    if ($error) {
        array_push($errors, $error);
        return null;
    }

    return $result;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        if (!isset($_POST['name'])) {
            $name = explode('@', $_POST['email'])[0];
        } else {
            $name = $_POST['name'];
        }
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = createAdmin($name, $email, $password);
        $token = authenticate($email, $password);
        if ($token && $user) {
            setAuthCookie($token);
            redirect("/admin_dashboard.php");
        }
    } else {
        array_push($errors, "Please fill in all fields");
    }
}
?>
<main>
    <!--  All page content goes here  -->
</main>

<!---------------------------------------------------------------------------------->
<?php include 'partials/footer.php'; ?>
</body>
</html>

