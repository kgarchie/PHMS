<!Doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>

<body>
<?php include 'partials/header.php' ?>
<?php global $errors, $db, $mail,
             $successes; ?>
<!----------------------------------------------------------------------------------->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vaccine_id = $_POST['vaccine_id'];
    $patient_id = $_POST['patient_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    [$result, $error] = $db->query("INSERT INTO vaccinations (vaccine_id, kid_id, date, time) VALUES (?, ?, ?, ?)", $vaccine_id, $patient_id, $date, $time);
    if ($error) {
        array_push($errors, $error);
    } else {
        array_push($successes, "Vaccination added successfully");
    }
}
?>
<main class="d-flex">
    <?php include 'partials/aside.php'; ?>
    <div class="wrapper w-100">
        <form method="post" action="/vaccination_add.php" class="w-50 mx-auto my-4 shadow-sm p-4 rounded bg-white">
            <h4 class="text-lg text-capitalize" style="font-weight: 700">Schedule Vaccination</h4>
            <div>
                <h5 class="heading mt-3">Vaccine</h5>
                <div class="mb-2 row position-relative">
                    <div class="position-relative">
                        <input name="search_input" type="text" class="form-control" id="searchVaccine"
                               autocomplete="off"
                               aria-describedby="searchInput" placeholder="Search for vaccine"
                               title="search for vaccine"
                               oninput="searchVac(this)">
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
                    <div class="search-results vaccine position-absolute z-3">
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

                        .search-results ul li .vaccine-name {
                            font-weight: 700;
                            display: inline-block;
                        }

                        .search-results ul li .vaccine-dose {
                            font-size: 0.8rem;
                            margin-left: auto;
                            color: #6c757d;
                        }
                    </style>
                    <script defer>
                        const vaccineSearchResults = document.querySelector('.search-results ul');

                        function searchVac(element) {
                            const term = element.value;
                            vaccineSearchResults.innerHTML = '';
                            if (term.trim() === '') return
                            fetch('/api_vaccines_search.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: `search_input=${term}`
                            }).then(response => response.json()).then(
                                data => {
                                    data.forEach(vaccine => {
                                        const li = document.createElement('li');
                                        li.classList.add('list-group-item');
                                        li.innerHTML = `
                                            <div class="d-flex">
                                                <div class="vaccine-name">${vaccine.name}</div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="vaccine-dose">${vaccine.description}</div>
                                            </div>
                                            `;
                                        li.onclick = selectVaccine.bind(null, vaccine);
                                        vaccineSearchResults.appendChild(li);
                                    });
                                })
                        }

                        function selectVaccine(vaccine) {
                            document.getElementById('vaccine_id_input').value = vaccine.id;
                            const selectedParent = document.getElementById('selectedVaccine');
                            document.getElementById('searchVaccine').value = vaccine.name;
                            vaccineSearchResults.innerHTML = '';
                            selectedParent.innerHTML = `
                                <div class="card-header">
                                    <span class="card-title">${vaccine.name}</span>
                                </div>
                                <div class="card-body d-flex justify-content-between">
                                    <h6 class="card-subtitle mb-2 text-muted">${vaccine.description}</h6>
                                </div>
                            `;
                        }
                    </script>
                </div>
                <div>
                    <button type="button" class="link-primary btn" data-bs-toggle="modal" data-bs-target="#modal">
                        Add New Vaccine
                    </button>
                </div>
                <div class="mt-3 card" id="selectedVaccine">
                    <!-- selected vaccine goes here -->
                </div>
            </div>
            <div>
                <h5 class="heading mt-3">Patient</h5>
                <div class="mb-2 row position-relative">
                    <div class="position-relative">
                        <input name="search_input" type="text" class="form-control" id="searchPatient"
                               autocomplete="off"
                               aria-describedby="searchInput" placeholder="Search for vaccine"
                               oninput="searchKid(this)"
                               title="search for vaccine">
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
                    <div class="search-results patient position-absolute z-3">
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

                        .search-results ul li .patient-name {
                            font-weight: 700;
                            display: inline-block;
                        }

                        .search-results ul li .patient-dose {
                            font-size: 0.8rem;
                            margin-left: auto;
                            color: #6c757d;
                        }
                    </style>
                    <script defer>
                        const patientSearchResults = document.querySelector('.search-results.patient ul');

                        function searchKid(element) {
                            const term = element.value;
                            patientSearchResults.innerHTML = '';
                            if (term.trim() === '') return
                            fetch('/api_patients_search.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: `search_input=${term}`
                            }).then(response => response.json()).then(
                                /** @param {Patient[]} data */
                                data => {
                                    data.forEach(patient => {
                                        const li = document.createElement('li');
                                        li.classList.add('list-group-item');
                                        li.innerHTML = `
                                            <div class="d-flex">
                                                <div class="vaccine-name">${patient.name}</div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="vaccine-dose">${patient.parent_name}</div>
                                            </div>
                                            `;
                                        li.onclick = selectPatient.bind(null, patient);

                                        patientSearchResults.appendChild(li);
                                    });
                                })
                        }

                        /**
                         * @param {Patient} patient
                         */
                        function selectPatient(patient) {
                            document.getElementById('patient_id_input').value = patient.kid_id;
                            const selectedPatient = document.getElementById('selectedPatient');
                            document.getElementById('searchPatient').value = patient.name;
                            patientSearchResults.innerHTML = '';
                            selectedPatient.innerHTML = `
                                <div class="card-header">
                                    <span class="card-title">${patient.name}</span>
                                </div>
                                <div class="card-body d-flex mt-2 justify-content-between">
                                    <h6 class="card-subtitle mb-2 text-muted">Type: ${patient.category}</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">Parent: ${patient.parent_name}</h6>
                                </div>
                                <div class="card-footer">
                                    <a href="patient_details.php?kid_id=${patient.kid_id}" class="">View Details</a>
                                </div>
                            `;
                        }
                    </script>
                </div>
                <div>
                    <a href="/patient_add.php" class="link-primary btn">
                        Add New Patient
                    </a>
                </div>
                <div class="mt-3 card" id="selectedPatient">
                    <!-- selected patient goes here -->
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
            <input type="hidden" name="vaccine_id" id="vaccine_id_input" required>
            <input type="hidden" name="patient_id" id="patient_id_input" required>

            <div class="mt-3 d-flex">
                <button type="submit" class="btn btn-success" style="margin-left: auto">Schedule Vaccination
                </button>
            </div>
        </form>
    </div>
    <div class="modal fade modal-lg" id="modal" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal">Add New Parent</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="add_vaccine_form">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" aria-describedby="nameInput"
                                   name="name" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control"
                                      id="description"
                                      aria-describedby="descriptionHelp"
                                      name="description"
                                      autocomplete="off"
                                      required>
                            </textarea>
                        </div>
                    </form>
                    <script defer>
                        function submitParentData() {
                            const form = document.getElementById('add_vaccine_form');
                            const formData = new FormData(form);
                            fetch('/api_vaccine_add.php', {
                                method: 'POST',
                                contentType: 'application/x-www-form-urlencoded',
                                body: formData
                            }).then(response => {
                                return response.json().catch(() => {
                                    ToastError('Fatal Error Occurred While Adding A Vaccine')
                                    console.log(response.body)
                                    return null
                                })
                            }).then(
                                /** @param {{parent_id: string} | null} data */
                                data => {
                                    if (data.success) {
                                        form.reset()
                                        document.querySelector('#modal').querySelector('[data-bs-dismiss]').click()
                                        ToastSuccess('Vaccine Added Successfully')

                                        const vaccine = {
                                            id: data.parent_id,
                                            name: formData.get('name'),
                                            description: formData.get('description')
                                        }

                                        selectVaccine(vaccine)
                                    } else {
                                        ToastError('Unable to add vaccine')
                                    }
                                }).catch(console.error)
                        }
                    </script>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" onclick="submitParentData()">
                        Submit
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<!---------------------------------------------------------------------------------->
<?php include 'partials/footer.php'; ?>
</body>

</html>