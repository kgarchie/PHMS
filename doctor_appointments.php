<!Doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>

<body>
<?php include 'partials/header.php' ?>
<?php global $errors, $db, $mail,
             $successes; ?>
<!----------------------------------------------------------------------------------->
<?php
function getAppointments($doctor_id)
{
    global $errors, $db;
    [$result, $error] = $db->query("SELECT * FROM appointments WHERE doctor_id = ?", $doctor_id);
    if ($error) {
        array_push($errors, $error);
        return null;
    }

    return $result->groupBy('date');
}

function getDoctor($id)
{
    global $errors, $db;
    [$result, $error] = $db->query("SELECT * FROM doctors WHERE id = ?", $id);
    if ($error) {
        array_push($errors, $error);
        return null;
    }

    return $result->first();
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
    if (isset($_GET['doctor_id'])) {
        $dates = getAppointments($_GET['doctor_id']);
        $doctor = getDoctor($_GET['doctor_id']);
    }
}
?>
<main class="d-flex">
    <?php include 'partials/aside.php'; ?>
    <div class="container w-100">
        <?php if (isset($dates)) { ?>
            <div class="wrapper">
                <h3 class="heading mt-3 mt-0">Appointments</h3>
                <div class="flex">
                    <h5 class="doctor-name"><span><?php echo $doctor->get('name') ?></span></h5>
                </div>
                <?php foreach ($dates as $date => $appointments) { ?>
                    <h3 class="heading date mt-4"><span><?php echo $date ?></span></h3>
                    <div class="appointments">
                        <?php foreach ($appointments as $appointment) { ?>
                            <?php $kid = getPatientDetails($appointment['kid_id']); ?>
                            <div class="w-100 h-100 position-relative">
                                <div class="hr"><span><?php echo $appointment['time'] ?></span></div>
                            </div>
                            <div class="appointment">
                                <div class="appointment-details">
                                    <h4><?php echo $kid->get('name') ?></h4>
                                    <small class="email"><?php echo $kid->get('email') ?></small>
                                    <small class="phone"><?php echo $kid->get('phone') ?></small>
                                </div>
                                <div class="reason">
                                    <p><?php echo $appointment['reason'] ?></p>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="alert alert-info">No appointments found</div>
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

    .doctor-name span::before {
        content: "Dr. ";
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