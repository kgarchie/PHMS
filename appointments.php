<!Doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>

<body>
<?php include 'partials/header.php' ?>
<?php global $errors, $db, $mail,
             $successes; ?>
<!----------------------------------------------------------------------------------->
<?php
?>
<main class="d-flex">
    <?php include 'partials/aside.php'; ?>
    <div class="wrapper w-100">
        <div class="container">
            <div class="row">
                <div class="col-6 m-auto">
                    <h4 class="mt-4 text-capitalize" style="font-weight: 700">Book an Appointment</h4>
                    <form action="/appointments.php" method="post" class="card p-4">
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="time">Time</label>
                                    <input type="time" class="form-control" id="time" name="time" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label for="doctor">Doctor</label>
                            <select class="form-control" id="doctor" name="doctor" required>
                                <option value="">Select Doctor</option>
                                <option value="1">Dr. John Doe</option>
                                <option value="2">Dr. Jane Doe</option>
                                <option value="3">Dr. Richard Roe</option>
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="reason">Reason</label>
                            <textarea class="form-control" id="reason" name="reason" required></textarea>
                        </div>
                        <div class="form-group mt-2">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="btn-group mt-2">
                            <button type="submit" class="btn btn-primary">Book</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<!---------------------------------------------------------------------------------->
<?php include 'partials/footer.php'; ?>
</body>

</html>