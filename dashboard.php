<!doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>
<body>
<?php include 'partials/header.php' ?>
<?php if (!getAuthCookie()) redirect("login.php"); ?>
<main class="container">
    <h1>Dashboard</h1>
    <p>Welcome to the dashboard</p>
</main>
<?php include 'partials/footer.php'; ?>
</body>
</html>