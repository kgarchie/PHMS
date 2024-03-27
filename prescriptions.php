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
            <a class="btn btn-success mt-3" href="prescription_add.php?patient_id=<?php echo $patient_id ?>">New
                Prescription</a>
            <?php $kid = getPatientDetails($prescriptions->first()->get('id')); ?>
            <h4 class="heading mt-3 mb-2"><?php echo $kid->get('name') ?></h4>
            <?php for ($i = 0; $i < $prescriptions->count(); $i++) { ?>
                <?php $prescription = $prescriptions->at($i) ?>
                <div class="card">
                    <h5 class="card-header">
                        <?php
                        $datetime = $prescription->get('created_at');
                        $date = date_create($datetime);
                        echo date_format($date, 'd-m-Y H:i:s');
                        ?>
                    </h5>
                    <div class="card-body">
                        <p class="card-text"><?php echo $prescription->get('prescription') ?></p>
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