<!Doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>

<body>
<?php include 'partials/header.php' ?>
<?php global $errors,
             $db,
             $mail,
             $successes; ?>
<!----------------------------------------------------------------------------------->
<?php
function makeAppointment($kid_id, $doctor_id, $date, $time, $reason)
{
    global $errors, $db, $mail, $successes;

    $reason = trim($reason);
    [$_, $error] = $db->query("INSERT INTO appointments (`kid_id`, `doctor_id`, `date`, `time`, `reason`) VALUES (?, ?, ?, ?, ?)", $kid_id, $doctor_id, $date, $time, $reason);
    if ($error) {
        array_push($errors, $error);
        return;
    }

    [$kid, $error] = $db->query("SELECT * FROM kids WHERE id = ?", $kid_id);
    [$doctor, $error] = $db->query("SELECT * FROM doctors WHERE id = ?", $doctor_id);

    $kid_name = $kid->first()->get('name');
    $doctor_name = $doctor->first()->get('name');
    $doctor_email = $doctor->first()->get('email');

    $body = "Hello Dr. $doctor_name, $kid_name has booked an appointment with you on $date at $time for $reason";
    $mail->send($doctor_email, "New Appointment", $body);

    array_push($successes, "Appointment booked successfully");

    redirect('./appointments.php');

}

[$doctors, $error] = $db->query("SELECT doctors.id, doctors.name FROM doctors");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kid_id = $_POST['kid_id'];
    $doctor_id = $_POST['doctor'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $reason = $_POST['reason'];

    makeAppointment($kid_id, $doctor_id, $date, $time, $reason);
}
?>
<main class="d-flex">
    <?php include 'partials/aside.php'; ?>
    <div class="wrapper w-100">
        <div class="container my-4">
            <div class="row">
                <div class="col-6 m-auto">
                    <h4 class="mt-4 text-capitalize" style="font-weight: 700">Book an Appointment</h4>
                    <form action="/appointment_add.php" method="post" class="card p-4">
                        <div class="patient">
                            <h5 class="heading">Patient</h5>
                            <div class="mb-2 row position-relative">
                                <div class="position-relative">
                                    <input name="search_input" type="text" class="form-control" id="search"
                                           autocomplete="off"
                                           aria-describedby="searchInput" placeholder="Search for patient"
                                           title="search for parent"
                                           oninput="searchParents(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                         class="icon">
                                        <path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"></path>
                                    </svg>
                                    <style>
                                        .icon {
                                            position: absolute;
                                            right: 1rem;
                                            top: 0;
                                            bottom: 0;
                                            margin: auto;
                                            width: 1.5rem;
                                            height: 1.5rem;
                                            fill: #6c757d;
                                        }
                                    </style>
                                </div>
                                <div class="search-results position-absolute z-3">
                                    <ul class="list-group shadow">
                                        <!-- search results go here -->
                                    </ul>
                                </div>
                                <style>
                                    .search-results {
                                        top: 100%;
                                        z-index: 1000;
                                        width: 100%;
                                        max-height: 200px;
                                        overflow-y: auto;
                                    }

                                    .search-results::-webkit-scrollbar {
                                        display: none;
                                    }

                                    .search-results ul li {
                                        cursor: pointer;
                                    }

                                    .search-results ul li:hover {
                                        background-color: #f8f9fa;
                                    }

                                    .search-results ul li .parent-name {
                                        font-weight: 700;
                                        display: inline-block;
                                    }

                                    .search-results ul li .parent-address {
                                        font-size: 0.9rem;
                                        margin-left: auto;
                                    }

                                    .search-results ul li .parent-email {
                                        font-size: 0.8rem;
                                        margin-left: 0.2em;
                                        color: #6c757d;
                                    }

                                    .search-results ul li .parent-phone {
                                        font-size: 0.8rem;
                                        margin-left: auto;
                                        color: #6c757d;
                                    }
                                </style>
                                <script defer>
                                    const searchResults = document.querySelector('.search-results ul');

                                    function searchParents(element) {
                                        const term = element.value;
                                        searchResults.innerHTML = '';
                                        if (term.trim() === '') return
                                        fetch('/api_patients_search.php', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/x-www-form-urlencoded'
                                            },
                                            body: `search_input=${term}`
                                        }).then(response => response.json()).then(
                                            data => {
                                                data.forEach(kid => {
                                                    const li = document.createElement('li');
                                                    li.classList.add('list-group-item');
                                                    li.innerHTML = `
                                            <div class="d-flex">
                                                <div class="parent-name">${kid.name}</div>
                                                <div class="parent-address">${kid.parent_name}</div>
                                            </div>
                                            `;
                                                    li.onclick = selectKid.bind(null, kid);
                                                    searchResults.appendChild(li);
                                                });
                                            })
                                    }

                                    function selectKid(kid) {
                                        document.getElementById('kid_id_input').value = kid.kid_id;
                                        document.getElementById('email').value = kid.email;
                                        const selectedKid = document.getElementById('selectedKid');
                                        document.getElementById('search').value = kid.name;
                                        searchResults.innerHTML = '';
                                        selectedKid.innerHTML = `
                                <div class="card-header">
                                    <span class="card-title">${kid.name}</span>
                                </div>
                                <div class="card-body d-flex justify-content-between">
                                    <h6 class="card-subtitle mb-2 text-muted">${kid.parent_name}</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">${kid.dob}</h6>
                                </div>
                            `;
                                    }
                                </script>
                            </div>
                            <div>
                                <a class="btn btn-primary" href="./patient_add.php">
                                    Add New Patient
                                </a>
                            </div>
                            <div class="mt-3 card" id="selectedKid">
                                <!-- selected parent goes here -->
                            </div>
                        </div>
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
                                <?php if ($doctors->count() > 0) ?>
                                <?php for ($i = 0; $i < $doctors->count(); $i++) : ?>
                                    <option value="<?php echo $doctors->at($i)->get('id') ?>"><?php echo $doctors->at($i)->get('name') ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="reason">Reason</label>
                            <textarea class="form-control" id="reason" name="reason" required></textarea>
                        </div>
                        <div class="btn-group mt-2">
                            <button type="submit" class="btn btn-primary">Book</button>
                        </div>

                        <input type="hidden" id="kid_id_input" name="kid_id">
                        <input type="hidden" id="email" name="email" required>
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