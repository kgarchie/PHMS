<!Doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>

<body>
<?php include 'partials/header.php' ?>
<?php global $errors, $db, $mail,
             $successes; ?>
<!----------------------------------------------------------------------------------->
<?php
function addDoctor($name, $email, $phone, $address): bool
{
    global $db, $errors;
    [$result, $error] = $db->query("INSERT INTO doctors (name, email, phone, address) values (?, ?, ?, ?)", $name, $email, $phone, $address);
    if ($error) {
        array_push($errors, $error);
        return false;
    }

    return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['doctor_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = null;
    if (isset($_POST['address'])) {
        $address = $_POST['address'];
    }

    $result = addDoctor($name, $email, $phone, $address);
    if ($result) {
        array_push($successes, "Doctor added successfully bitch");
        redirect('/doctors.php');
    } else {
        array_push($errors, "Huston we have a problem");
    }
}

?>
<main class="d-flex">
    <?php include 'partials/aside.php'; ?>
    <div class="wrapper w-100">
        <form action="/doctor_add.php" method="POST" class="w-50 mx-auto mt-5 shadow-sm p-4 rounded" id="register-form">
            <div class="mb-3">
                <label for="doctor_name" class="form-label">Doctor Name</label>
                <input type="text" class="form-control" id="doctor_name" aria-describedby="usernameHelp"
                       name="doctor_name"
                       autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email"
                       autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Home Address</label>
                <input type="text" class="form-control" id="address" name="address" autocomplete="off">
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-primary d-inline-block">Submit</button>
            </div>
        </form>
    </div>
</main>

<!---------------------------------------------------------------------------------->
<?php include 'partials/footer.php'; ?>
</body>

</html>