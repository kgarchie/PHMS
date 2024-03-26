<!Doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>

<body>
<?php include 'partials/header.php' ?>
<?php global $errors, $db, $mail,
             $successes; ?>
<!----------------------------------------------------------------------------------->
<?php
[$doctors, $error] = $db->query("SELECT * FROM doctors");
if ($error) {
    array_push($errors, $error);
}

?>
<main class="d-flex">
    <?php include 'partials/aside.php'; ?>
    <div class="wrapper w-100">
        <div class="doctors">
            <a class="btn btn-success" href="./appointment_add.php">New Appointment</a>
            <input name="search_input" type="text" class="form-control mb-3" id="search" autocomplete="off"
                   aria-describedby="searchInput" placeholder="Search for doctor" title="search for parent"
                   oninput="searchDoctors(this)">
            <div class="doctors-list">
                <?php for ($i = 0; $i < $doctors->count(); $i++) : ?>
                    <a class="doctor" href="/doctor_appointments.php?doctor_id=<?php echo $doctors->at($i)->get('id') ?>">
                        <h3><?php echo $doctors->at($i)->get('name') ?></h3>
                        <p><?php echo $doctors->at($i)->get('phone') ?></p>
                        <p><?php echo $doctors->at($i)->get('email') ?></p>
                    </a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</main>
<style>
    .doctors {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 1000px;
        margin: 2rem auto auto;
        padding: 2rem;
    }

    .doctors-list {
        display: flex;
        flex-direction: column;
        border: 4px solid #f1f1f1;
    }

    .doctor {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        padding: 1rem;
        cursor: pointer;
    }

    .doctor:nth-child(odd) {
        background-color: #f9f9f9;
    }

    .doctor:hover {
        background-color: #dcdcdc;
    }

    .doctor > * {
        display: flex;
        align-items: center;
        height: 100%;
    }

    .doctor h3 {
        font-size: 1.15rem;
        font-weight: 500;
    }
</style>
<script>
    function searchDoctors(input) {
        const doctors = document.querySelectorAll('.doctor');
        doctors.forEach(doctor => {
            if (doctor.innerText.toLowerCase().includes(input.value.toLowerCase())) {
                doctor.style.display = 'grid';
            } else {
                doctor.style.display = 'none';
            }
        });
    }
</script>

<!---------------------------------------------------------------------------------->
<?php include 'partials/footer.php'; ?>
</body>

</html>