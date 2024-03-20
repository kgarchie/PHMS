<!Doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>

<body>
<?php include 'partials/header.php' ?>
<?php global $errors, $db, $mail,
             $successes; ?>
<!----------------------------------------------------------------------------------->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['kid_id'])) {
        $kid_id = $_GET['kid_id'];
        [$result, $error] = $db->query("SELECT * FROM kids WHERE `id` = ?", $kid_id);
        if ($error) {
            array_push($errors, $error);
        } else {
            $kid = $result->first();
            if (!$kid) {
                array_push($errors, "No kid found with that id");
            }
        }
    } else {
        echo "No kid id provided";
    }
}
?>
<main class="d-flex">
    <?php include 'partials/aside.php'; ?>
    <div class="wrapper w-100">

    </div>
</main>

<!---------------------------------------------------------------------------------->
<?php include 'partials/footer.php'; ?>
</body>

</html>