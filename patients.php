<!Doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>

<body>
<?php include 'partials/header.php' ?>

<?php global $errors, $db, $mail, $successes; ?>
<!----------------------------------------------------------------------------------->
<?php
[$result, $error] = $db->query("SELECT kids.id as kid_id, kids.name, kids.dob, kids.category, parents.name as parent_name, parents.id as parent_id FROM kids JOIN parents ON kids.parent_id = parents.id");
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
                <input placeholder="search patient" class="search-input shadow-sm" type="text" id="search_input"
                       name="search_input" title="search">
                <script defer>
                    const searchInput = document.getElementById('search_input');
                    searchInput.addEventListener('input', () => {
                        const search = searchInput.value;
                        const tbody = document.getElementById('tbody');
                        fetch('/api_patients_search.php', {
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
                            /** @param {Patient[]} data */
                            data => {
                                tbody.innerHTML = ``;
                                data.forEach((kid, index) => {
                                    const tr = document.createElement('tr');
                                    tr.classList.add('table-row');
                                    tr.innerHTML = "" +
                                        "<th scope='row'>" + (index + 1) + "</th>" +
                                        "<td>" + kid.name + "</td>" +
                                        "<td>" + kid.dob + "</td>" +
                                        "<td class='text-capitalize'>" + kid.category + "</td>" +
                                        "<td class='color-hover' data-parent_id='" + kid.parent_id + "' onclick='openParent(event)'>" + kid.parent_name + "</td>" +
                                        "<td class='actions'>" +
                                        "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor' id='edit_" + kid.kid_id + "'>" +
                                        "<path d='M5 18.89H6.41421L15.7279 9.57627L14.3137 8.16206L5 17.4758V18.89ZM21 20.89H3V16.6473L16.435 3.21231C16.8256 2.82179 17.4587 2.82179 17.8492 3.21231L20.6777 6.04074C21.0682 6.43126 21.0682 7.06443 20.6777 7.45495L9.24264 18.89H21V20.89ZM15.7279 6.74785L17.1421 8.16206L18.5563 6.74785L17.1421 5.33363L15.7279 6.74785Z'></path>" +
                                        "</svg>" +
                                        "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='currentColor' id='delete_" + kid.kid_id + "'>" +
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
                    <a class="btn btn-success" href="/patient_add.php" style="border-radius: 2px">Add Patient</a>
                </div>
                <table class="table custom-table shadow table-responsive table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Age</th>
                        <th scope="col">Category</th>
                        <th scope="col">Parent</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody id="tbody">
                    <?php if ($result->count() > 0) ?>
                    <?php for ($i = 0; $i < $result->count(); $i++) :
                        $kid_id = $result->at($i)->get('kid_id'); ?>
                        <tr class="table-row" data-kid_id="<?php echo $kid_id ?>">
                            <th scope="row"><?php echo $i + 1 ?></th>
                            <td><?php echo $result->at($i)->get('name') ?></td>
                            <td><?php echo $result->at($i)->get('dob') ?></td>
                            <td class="text-capitalize"><?php echo $result->at($i)->get('category') ?></td>
                            <td class="color-hover" data-parent_id="<?php echo $result->at($i)->get('parent_id') ?>"
                                onclick="openParent(event)"><?php echo $result->at($i)->get('parent_name') ?></td>
                            <td class="actions">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="currentColor" <?php echo 'id="edit_' . $kid_id . '"' ?>>
                                    <path d="M5 18.89H6.41421L15.7279 9.57627L14.3137 8.16206L5 17.4758V18.89ZM21 20.89H3V16.6473L16.435 3.21231C16.8256 2.82179 17.4587 2.82179 17.8492 3.21231L20.6777 6.04074C21.0682 6.43126 21.0682 7.06443 20.6777 7.45495L9.24264 18.89H21V20.89ZM15.7279 6.74785L17.1421 8.16206L18.5563 6.74785L17.1421 5.33363L15.7279 6.74785Z"></path>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                     fill="currentColor" <?php echo 'id="delete_' . $kid_id . '"' ?>>
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

    <template id="edit-template">
        <form id="edit-form">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="patient_name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" id="patient_dob" name="dob" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" id="category" name="patient_category" required>
                    <option value="outpatient">OutPatient</option>
                    <option value="inpatient">Inpatient</option>
                </select>
            </div>
        </form>
    </template>
</main>
<script defer>
    const tbody = document.getElementById('tbody');
    const modal = new bootstrap.Modal(document.getElementById('modal'));

    /**
     * @param {string} title
     * @param {string} content
     */
    function launchModal(title, content) {
        modal.show();
        const modalTitle = modal._element.querySelector('.modal-title');
        const modalBody = modal._element.querySelector('.modal-body');
        modalTitle.textContent = title;
        modalBody.innerHTML = content;
    }


    function openParent(event) {
        stopEvent(event);
        fetch(`/api_parent_details.php?parent_id=${event.target.dataset.parent_id}`)
            .then(response => {
                return response.json().catch(() => {
                    alert('An error occurred while processing your request');
                })
            }).then(
            /** @param {ParentAndKids} data */
            data => {
                const {
                    parent,
                    kids
                } = data;
                const parentContent = `
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text"><strong>Email:</strong> ${parent.email}</p>
                            <p class="card-text"><strong>Phone:</strong> ${parent.phone}</p>
                            <p class="card-text"><strong>Address:</strong> ${parent.address}</p>
                        </div>
                    </div>`;
                const kidsContent = `
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title">Kids</h5>
                            <ul class="list-group list-group-flush">
                                ${kids.map(kid => `<li class="list-group-item">${kid.name}</li>`).join('')}
                            </ul>
                        </div>
                    </div>`;
                launchModal(parent.name, parentContent + kidsContent);
            });
    }

    function setUpTable() {
        const tableRows = tbody.querySelectorAll('.table-row');
        tableRows.forEach(row => {
            row.addEventListener('click', () => {
                const kidId = row.dataset.kid_id;
                window.location.href = `/patient_details.php?kid_id=${kidId}`;
            })
        })

        const actions = tbody.querySelectorAll('.actions');
        actions.forEach(action => {
            action.addEventListener('click', stopEvent)
        })

        const editButtons = tbody.querySelectorAll('svg[id^="edit_"]');
        editButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const patient_id = button.id.split('_')[1]
                fetch(`/api_patient_get.php?patient_id=${patient_id}`)
                    .then(response => {
                        return response.json().catch(() => {
                            alert('An error occurred while processing your request');
                        })
                    }).then(
                    /** @param {Patient} data */
                    data => {
                        const template = document.getElementById('edit-template');
                        const form = template.content.querySelector('form');
                        launchModal(`Edit ${data.name}`, form.cloneNode(true).outerHTML);
                        const editForm = document.getElementById('edit-form');
                        editForm.name.value = data.name;
                        editForm.dob.value = data.dob;
                        editForm.category.value = data.category;

                        document.querySelector('.modal-footer').innerHTML = `
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="submitEditForm(${patient_id})">
                                        Close
                                    </button>`;
                    });
            });
        });

        const deleteButtons = tbody.querySelectorAll('svg[id^="delete_"]');
        deleteButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const patient_id = button.id.split('_')[1]
                fetch(`/api_patient_delete.php?patient_id=${patient_id}`, {
                    method: 'DELETE'
                }).then(response => {
                    return response.json().catch(() => {
                        alert('An error occurred while processing your request');
                    })
                }).then(
                    data => {
                        if (data.message === 'success') {
                            ToastSuccess('Patient deleted successfully');
                            setTimeout(() => {
                                window.location.reload();
                            }, 500);
                        } else {
                            ToastError('An error occurred while processing your request');
                        }
                    });
            });
        });
    }

    function submitEditForm(kidId) {
        const form = document.getElementById('edit-form');
        const name = form.name.value;
        const dob = form.dob.value;
        const category = form.category.value;

        fetch('/api_patient_edit.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `patient_name=${name}&patient_dob=${dob}&patient_category=${category}&patient_id=${kidId}`
        }).then(response => {
            return response.json().catch(() => {
                ToastError('An error occurred while processing your request');
            })
        }).then(
            data => {
                if (data.message === 'success') {
                    ToastSuccess('Patient updated successfully');
                    modal.hide();
                } else {
                    ToastError('An error occurred while processing your request');
                }
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
        margin-top: -20px;
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