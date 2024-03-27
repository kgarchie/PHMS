<!Doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>

<body>
<?php include 'partials/header.php' ?>
<?php global $errors, $db, $mail,
             $successes; ?>
<!----------------------------------------------------------------------------------->
<?php
function getVaccine($id)
{
    global $errors, $db;
    [$result, $error] = $db->query("SELECT * FROM vaccines WHERE id = ?", $id);
    if ($error) {
        array_push($errors, $error);
        return null;
    }

    return $result->first();
}

function getAllVaccinations()
{
    global $errors, $db;
    [$result, $error] = $db->query("SELECT * FROM vaccinations");
    if ($error) {
        array_push($errors, $error);
        return null;
    }

    return $result->groupBy('date');
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
    $vaccines = getAllVaccinations();
}
?>
<main class="d-flex">
    <?php include 'partials/aside.php'; ?>
    <div class="container w-100">
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
<style>
    .doctor-name {
        text-align: right;
        margin-right: 20px;
    }

    .doctor-name span {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.12);
        padding: 0.5rem 1rem;
        background-color: #f4f4f4;
    }

    .wrapper {
        max-width: 1000px;
        margin: auto;
        background-color: #ffffff;
        padding: 1rem 2rem;
        border-radius: 5px;
        margin-top: 1rem;
        margin-bottom: 1rem;
    }

    .appointment {
        display: flex;
        padding: 1rem;
        align-items: flex-start;
        background-color: #f4f4f4;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        border-radius: 8px;
    }

    .appointment-details {
        width: 30%;
        display: flex;
        flex-direction: column;
    }

    .appointment-details h4 {
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
    }

    .email, .phone {
        font-size: 0.9rem;
        color: #666;
    }

    .hr {
        padding: 0.5rem;
        text-align: center;
        isolation: isolate;
    }

    .hr::before,
    .hr::after {
        content: "";
        position: absolute;
        width: 50%;
        height: 1px;
        top: 50%;
        z-index: -1;
        background-color: grey;
    }

    .hr::before {
        left: 0;
    }

    .hr::after {
        right: 0;
    }

    .hr span {
        background-color: #ffffff;
        padding: 0.25rem 0.5rem;
    }



    .date {
        font-size: 1rem;
        margin-bottom: -0.5rem;
    }

    .reason {
        width: 70%;
        height: 80px;
        padding: 0.5rem;
        background-color: #f9f9f9;
    }
</style>
<!---------------------------------------------------------------------------------->
<?php include 'partials/footer.php'; ?>
</body>

</html>