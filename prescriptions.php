<!Doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>

<body>
<?php include 'partials/header.php' ?>
<?php global $errors, $db, $mail,
             $successes; ?>
<!----------------------------------------------------------------------------------->
<?php
function getPrescriptions($patient_id)
{
    global $errors, $db;
    [$result, $error] = $db->query("SELECT * FROM prescriptions WHERE kid_id = ?", $patient_id);
    if ($error) {
        array_push($errors, $error);
        return null;
    }

    return $result;
}

function getPatientDetails($kid_id)
{
    global $errors, $db;
    [$result, $error] = $db->query("SELECT kids.id, kids.name, kids.dob, parents.name, parents.email, parents.phone FROM kids JOIN parents ON kids.parent_id = parents.id WHERE kids.id = ?", $kid_id);
    if ($error) {
        array_push($errors, $error);
        return null;
    }

    return $result->first();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $patient_id = $_GET['patient_id'];
    $prescriptions = getPrescriptions($patient_id);
}
?>
<main class="d-flex">
    <?php include 'partials/aside.php'; ?>
    <div class="wrapper w-100">
        <div class="wrapper container">
            <a class="btn btn-success mt-3" href="prescription_add.php?patient_id=<?php echo $patient_id ?>">New Prescription</a>
            <h3 class="heading mt-3 mt-0">Prescriptions</h3>
            <?php for ($i = 0; $i < $prescriptions->count(); $i++) { ?>
                <?php $prescription = $prescriptions->get($i); ?>
                <?php $kid = getPatientDetails($prescription->get('kid_id')); ?>
                <div class="w-100 h-100 position-relative">
                    <div class="hr"><span><?php echo $prescription['date'] ?></span></div>
                </div>
                <div class="appointment">
                    <div class="appointment-details">
                        <h4><?php echo $kid->get('name') ?></h4>
                        <small class="email">Parent Email: <?php echo $kid->get('email') ?></small>
                        <small class="phone">Parent Phone: <?php echo $kid->get('phone') ?></small>
                    </div>
                    <div class="reason">
                        <span class="fw-bold"><?php echo $prescription['drug'] ?>:</span><br>
                        <small class="fw-bold"><?php echo $prescription['description'] ?></small><br>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</main>
<style>
    .wrapper {
        max-width: 1000px;
        margin: auto;
        background-color: #ffffff;
        padding: 1rem 2rem;
        border-radius: 5px;
        margin-top: 1rem;
        margin-bottom: 1rem;
    }
</style>
<!---------------------------------------------------------------------------------->
<?php include 'partials/footer.php'; ?>
</body>

</html>