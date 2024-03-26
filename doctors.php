<!Doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>

<body>
<?php include 'partials/header.php' ?>

<?php global $errors, $db, $mail, $successes; ?>
<!----------------------------------------------------------------------------------->
<?php
[$result, $error] = $db->query("SELECT doctors.id, doctors.name, doctors.email, doctors.phone FROM doctors");
if ($error) array_push($errors, $error);
?>
<main class="d-flex">
    <?php include 'partials/aside.php'; ?>
    <div class="wrapper w-100">
        <div class="d-flex flex-column align-items-center justify-content-center w-100">
            <div class="search">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z"></path>
                </svg>
                <input placeholder="Search Doctor" class="search-input shadow-sm" type="text" id="search_input"
                       name="search_input" title="search">
                <script defer>
                    const searchInput = document.getElementById('search_input');
                    searchInput.addEventListener('input', () => {
                        const search = searchInput.value;
                        const tbody = document.getElementById('tbody');
                        fetch('/api_doctors_search.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: `search_input=${search}`
                        }).then(response => {
                            return response.json().catch(() => {
                                alert('An error occurred while processing your request');
                            })
                        }).then(
                            /** @param {Doctor[]} data */
                            data => {
                                tbody.innerHTML = ``;
                                data.forEach((doctor, index) => {
                                    const tr = document.createElement('tr');
                                    tr.classList.add('table-row');
                                    tr.innerHTML = "" +
                                        "<th scope='row'>" + (index + 1) + "</th>" +
                                        "<td>" + doctor.name + "</td>" +
                                        "<td>" + doctor.email + "</td>" +
                                        "<td class='text-capitalize'>" + doctor.phone + "</td>" +
                                        "<td>" + (doctor.address ? doctor.address : 'No Address') + "</td>" +
                                        "<td class='actions'>" +
                                        "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor' id='edit_" + doctor.id + "'>" +
                                        "<path d='M5 18.89H6.41421L15.7279 9.57627L14.3137 8.16206L5 17.4758V18.89ZM21 20.89H3V16.6473L16.435 3.21231C16.8256 2.82179 17.4587 2.82179 17.8492 3.21231L20.6777 6.04074C21.0682 6.43126 21.0682 7.06443 20.6777 7.45495L9.24264 18.89H21V20.89ZM15.7279 6.74785L17.1421 8.16206L18.5563 6.74785L17.1421 5.33363L15.7279 6.74785Z'></path>" +
                                        "</svg>" +
                                        "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor' id='delete_" + doctor.id + "'>" +
                                        "<path d='M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM18 8H6V20H18V8ZM13.4142 13.9997L15.182 15.7675L13.7678 17.1817L12 15.4139L10.2322 17.1817L8.81802 15.7675L10.5858 13.9997L8.81802 12.232L10.2322 10.8178L12 12.5855L13.7678 10.8178L15.182 12.232L13.4142 13.9997ZM9 4V6H15V4H9Z'></path>" +
                                        "</svg>" +
                                        "</td>";
                                    tbody.appendChild(tr);
                                });

                                setUpTable();
                            });
                    });
                </script>
            </div>

            <div class="table-container">
                <div class="mt-5 mb-2">
                    <a class="btn btn-success" href="/doctor_add.php" style="border-radius: 2px">Add Doctor</a>
                </div>
                <table class="table custom-table shadow table-responsive table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Address</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id="tbody">
                    <?php if ($result->count() > 0) ?>
                    <?php for ($i = 0; $i < $result->count(); $i++) :
                        $doctor_id = $result->at($i)->get('id'); ?>
                        <tr class="table-row">
                            <th scope="row"><?php echo $i + 1 ?></th>
                            <td><?php echo $result->at($i)->get('name') ?></td>
                            <td><?php echo $result->at($i)->get('email') ?></td>
                            <td><?php echo $result->at($i)->get('phone') ?></td>
                            <td class="text-capitalize"><?php
                                if ($result->at($i)->get('address') !== null) {
                                    echo $result->at($i)->get('address');
                                } else {
                                    echo "No Address";
                                }
                                ?></td>
                            <td class="actions">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="currentColor" <?php echo 'id="edit_' . $doctor_id . '"' ?>>
                                    <path d="M5 18.89H6.41421L15.7279 9.57627L14.3137 8.16206L5 17.4758V18.89ZM21 20.89H3V16.6473L16.435 3.21231C16.8256 2.82179 17.4587 2.82179 17.8492 3.21231L20.6777 6.04074C21.0682 6.43126 21.0682 7.06443 20.6777 7.45495L9.24264 18.89H21V20.89ZM15.7279 6.74785L17.1421 8.16206L18.5563 6.74785L17.1421 5.33363L15.7279 6.74785Z"></path>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="currentColor" <?php echo 'id="delete_' . $doctor_id . '"' ?>>
                                    <path d="M17 6H22V8H20V21C20 21.5523 19.5523 22 19 22H5C4.44772 22 4 21.5523 4 21V8H2V6H7V3C7 2.44772 7.44772 2 8 2H16C16.5523 2 17 2.44772 17 3V6ZM18 8H6V20H18V8ZM13.4142 13.9997L15.182 15.7675L13.7678 17.1817L12 15.4139L10.2322 17.1817L8.81802 15.7675L10.5858 13.9997L8.81802 12.232L10.2322 10.8178L12 12.5855L13.7678 10.8178L15.182 12.232L13.4142 13.9997ZM9 4V6H15V4H9Z"></path>
                                </svg>
                            </td>
                        </tr>
                    <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade modal-lg" id="modal" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
<script defer>
    function setUpTable() {
        const tableRows = tbody.querySelectorAll('.table-row');
        tableRows.forEach(row => {
            row.addEventListener('click', () => {

            })
        })

        const actions = tbody.querySelectorAll('.actions');
        actions.forEach(action => {
            action.addEventListener('click', stopEvent)
        })

        const editButtons = tbody.querySelectorAll('svg[id^="edit_"]');
        editButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                console.log('edit clicked')
            });
        });

        const deleteButtons = tbody.querySelectorAll('svg[id^="delete_"]');
        deleteButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                console.log('delete clicked')
            });
        });
    }

    setUpTable();
</script>
<style>
    .search-input {
        padding: 0.3rem 0.6rem;
        padding-left: 2.25rem;
        width: 500px;
        margin-top: 1rem;
        border: 1px solid black;
        border-radius: 50px;
    }

    .search-input::placeholder {
        text-transform: capitalize;
    }

    .search {
        position: relative;
    }

    .search svg {
        position: absolute;
        top: 50%;
        left: 0.5rem;
        transform: translateY(-0.25rem);
        width: 1.5rem;
        height: 1.5rem;
    }

    .custom-table {
        width: 60vw;
    }

    .table-container {
        margin-top: -50px;
    }

    .actions {
        display: flex;
        gap: 5px;
    }

    .actions svg {
        width: 25px;
    }

    .table-row {
        cursor: pointer;
    }

    .table-row:hover td:not(.actions) {
        background-color: #f5f5f5;
    }

    .hidden {
        display: none;
    }

    .color-hover:hover {
        color: #007bff;
    }
</style>
<!---------------------------------------------------------------------------------->
<?php include 'partials/footer.php'; ?>
</body>

</html>