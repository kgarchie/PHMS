<!Doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>

<body>
<?php include 'partials/header.php' ?>
<?php global $errors, $db, $mail,
             $successes; ?>
<!----------------------------------------------------------------------------------->
<?php
function getVaccinations($id)
{
    global $errors, $db;
    [$result, $error] = $db->query("SELECT * FROM vaccinations WHERE id = ?", $id);
    if ($error) {
        array_push($errors, $error);
        return null;
    }

    return $result;
}


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $patient_id = $_GET['patient_id'];
    $vaccines = getVaccinations($patient_id);
}
?>
<main class="d-flex">
    <?php include 'partials/aside.php'; ?>
    <div class="wrapper w-100">
        <?php if (isset($vaccines)) { ?>
            <div class="wrapper">
                <h3 class="heading mt-3 mt-0">Vaccinations</h3>
                <a class="btn btn-success mt-3" href="./vaccination_add.php">New Vaccination Appointment</a>
                <?php foreach ($vaccines as $date => $vaccinations) { ?>
                    <h3 class="heading date mt-4"><span><?php echo $date ?></span></h3>
                    <div class="appointments">
                        <?php foreach ($vaccinations as $vaccine) { ?>
                            <?php $kid = getPatientDetails($vaccine['kid_id']); ?>
                            <div class="w-100 h-100 position-relative">
                                <div class="hr"><span><?php echo $vaccine['time'] ?></span></div>
                            </div>
                            <div class="appointment">
                                <div class="appointment-details">
                                    <h4><?php echo $kid->get('name') ?></h4>
                                    <small class="email">Parent Email: <?php echo $kid->get('email') ?></small>
                                    <small class="phone">Parent Phone: <?php echo $kid->get('phone') ?></small>
                                </div>
                                <div class="reason">
                                    <span class="fw-bold"><?php echo getVaccine($vaccine['vaccine_id'])->get('name') ?>:</span><br>
                                    <small class="fw-bold"><?php echo getVaccine($vaccine['vaccine_id'])->get('description') ?></small><br>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <a class="btn btn-success mt-3" href="./vaccination_add.php">New Vaccination Appointment</a>
            <div class="alert alert-info mt-2">No vaccinations found</div>
        <?php } ?>
    </div>
</main>

<!---------------------------------------------------------------------------------->
<?php include 'partials/footer.php'; ?>
</body>

</html>