<!Doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>

<body>
<?php include 'partials/header.php' ?>
<?php global $errors, $db, $mail,
             $successes; ?>
<!----------------------------------------------------------------------------------->
<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET['patient_id'])) {
        header('Location: patients.php');
    }
    $p_id = $_GET['patient_id'];
}

function addPrescription($doctor_id, $kid_id, $prescription): bool
{
    global $db, $errors;
    [$result, $error] = $db->query("INSERT INTO prescriptions (doctor_id, kid_id, prescription) values (?, ?, ?)", $doctor_id, $kid_id, $prescription);
    if ($error) {
        array_push($errors, $error);
        return false;
    }

    return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $kid_id = $_POST['kid_id'];
    $prescription = $_POST['prescription'];

    $result = addPrescription($doctor_id, $kid_id, $prescription);
    if ($result) {
        array_push($successes, "Prescription added successfully");
        redirect('/prescriptions.php?patient_id=' . $kid_id);
    } else {
        array_push($errors, "Huston we have a problem");
    }
}
?>
<main class="d-flex">
    <?php include 'partials/aside.php'; ?>
    <div class="wrapper w-100">
        <form action="/prescription_add.php" method="POST" class="w-50 mx-auto mt-5 shadow-sm p-4 rounded" id="register-form">
            <div class="mb-2 row position-relative">
                <div class="position-relative">
                    <label for="search" class="form-label">Doctor</label>
                    <input name="search_input" type="text" class="form-control" id="search" autocomplete="off"
                           aria-describedby="searchInput" placeholder="Search for parent" title="search for parent"
                           oninput="searchDoctors(this)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="icon">
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

                    function searchDoctors(element) {
                        const term = element.value;
                        searchResults.innerHTML = '';
                        if (term.trim() === '') return
                        fetch('/api_doctors_search.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `search_input=${term}`
                        }).then(response => response.json()).then(
                            /** @param {Array<Doctor>} data */
                            data => {
                                data.forEach(doctor => {
                                    const li = document.createElement('li');
                                    li.classList.add('list-group-item');
                                    li.innerHTML = `
                                            <div class="d-flex">
                                                <div class="parent-name">${doctor.name}</div>
                                                <div class="parent-address">${doctor.address}</div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="parent-email">${doctor.email}</div>
                                                <div class="parent-phone">${doctor.phone}</div>
                                            </div>
                                            `;
                                    li.onclick = selectDoctor.bind(null, doctor);
                                    searchResults.appendChild(li);
                                });
                            })
                    }

                    /** @param {Doctor} doctor */
                    function selectDoctor(doctor) {
                        document.getElementById('doctor_id_input').value = doctor.id;
                        const selectedDoctor = document.getElementById('selectedDoctor');
                        document.getElementById('search').value = doctor.name;
                        searchResults.innerHTML = '';

                        selectedDoctor.innerHTML = `
                                <div class="card-header">
                                    <span class="card-title">${doctor.name}</span>
                                </div>
                                <div class="card-body d-flex justify-content-between">
                                    <h6 class="card-subtitle mb-2 text-muted">${doctor.email}</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">${doctor.address}</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">${doctor.phone}</h6>
                                </div>
                            `;
                    }
                </script>
            </div>
            <div>
                <a class="btn link-primary" href="doctor_add.php">
                    Add New Doctor
                </a>
            </div>
            <div class="mt-3 card" id="selectedDoctor">
                <!-- selected parent goes here -->
            </div>
            <div class="mt-3 mb-3">
                <label for="prescription" class="form-label">Prescription</label>
                <input type="text" class="form-control" id="prescription" name="prescription" autocomplete="off">
            </div>
            <input type="hidden" name="kid_id" value="<?php echo $p_id ?>">
            <input type="hidden" id="doctor_id_input" name="doctor_id">
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