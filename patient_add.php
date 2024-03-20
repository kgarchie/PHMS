<!Doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>

<body>
<?php include 'partials/header.php' ?>
<?php global $errors, $db, $mail,
             $successes; ?>
<!----------------------------------------------------------------------------------->
<?php

function addKid($parent_id, $child_name, $child_dob, $child_category)
{
    global $db, $errors;
    [$_, $error] = $db->query("INSERT INTO kids (`name`, `dob`, `category`, `parent_id`) VALUES (?, ?, ?, ?)", $child_name, $child_dob, $child_category, $parent_id);
    if ($error) {
        array_push($errors, $error);
        return null;
    }

    return $_;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $parent_name = $_POST['parent_name'];
    $parent_email = $_POST['parent_email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $parent_id = $_POST['parent_id'];

    $child_name = $_POST['child_name'];
    $child_dob = $_POST['child_dob'];
    $child_category = $_POST['child_category'];

    if ($parent_id) {
        addKid($parent_id, $child_name, $child_dob, $child_category);
    } else {
        array_push($errors, "Failed to add parent");
    }
}
?>
<main class="d-flex">
    <?php include 'partials/aside.php'; ?>
    <div class="wrapper w-100">
        <form method="post" action="/patient_add.php" class="w-50 mx-auto my-5 shadow-sm p-4 rounded">
            <div class="parent">
                <h5 class="heading">Parent</h5>
                <div class="mb-3 row position-relative">
                    <div class="position-relative">
                        <input name="search_input" type="text" class="form-control" id="search" autocomplete="off"
                               aria-describedby="searchInput" placeholder="Search for parent" title="search for parent"
                               oninput="searchParents(this)">
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
                    <div class="search-results position-absolute">
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
                        function searchParents(element) {
                            const term = element.value;
                            const searchResults = document.querySelector('.search-results ul');
                            searchResults.innerHTML = '';
                            if (term.trim() === '') return
                            fetch('/api_parents_search.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: `search_input=${term}`
                            }).then(response => response.json()).then(
                                /** @param {Array<ParentSearchResult>} data */
                                data => {
                                    data.forEach(parent => {
                                        const li = document.createElement('li');
                                        li.classList.add('list-group-item');
                                        li.innerHTML = `
                                            <div class="d-flex">
                                                <div class="parent-name">${parent.name}</div>
                                                <div class="parent-address">${parent.address}</div>
                                            </div>
                                            <div class="d-flex">
                                                <div class="parent-email">${parent.email}</div>
                                                <div class="parent-phone">${parent.phone}</div>
                                            </div>
                                            `;
                                        li.onclick = selectParent.bind(null, parent.id);
                                        searchResults.appendChild(li);
                                    });
                                })
                        }

                        function selectParent(parentId) {
                            console.log(parentId);
                        }
                    </script>
                </div>
                <div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">
                        Add New Parent
                    </button>
                </div>
                
            </div>
            <div class="child">
                <h5 class="heading">Patient Details</h5>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" aria-describedby="nameInput" name="child_name"
                           autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="dob" class="form-label">DOB</label>
                    <input type="date" class="form-control" id="dob" aria-describedby="dobInput" name="child_dob"
                           autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select type="text" class="form-control form-select" id="category" aria-describedby="categoryInput"
                            name="child_category" required>
                        <option value="inpatient">Inpatient</option>
                        <option value="outpatient">Outpatient</option>
                    </select>
                </div>
                <style>
                    .heading {
                        font-family: 'Poppins', sans-serif;
                        font-weight: 700;
                    }

                    .parent {
                        background-color: rgba(187, 187, 187, 0.3);
                        padding: 2rem;
                    }

                    .child {
                        background-color: white;
                        padding: 2rem;
                    }
                </style>
            </div>
            <div class="mt-3 d-flex buttons justify-content-between">
                <button type="submit" class="btn btn-primary w-25">Submit</button>
                <button type="reset" class="btn btn-outline-primary w-25">Clear</button>
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
                    <form id="add_parent_form">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" aria-describedby="nameInput"
                                   name="parent_name" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                                   name="parent_email" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" aria-describedby="addressInput"
                                   name="address" autocomplete="off" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" aria-describedby="phoneInput"
                                   name="phone" autocomplete="off" required>
                        </div>
                    </form>
                    <script defer>
                        function submitParentData() {
                            const form = document.getElementById('add_parent_form');
                            const formData = new FormData(form);
                            fetch('/api_parent_add.php', {
                                method: 'POST',
                                body: formData
                            }).then(response => {
                                return response.json().catch(() => {
                                    alert('Fatal Error Occurred While Creating Parent')
                                    return null
                                })
                            }).then(
                                /** @param {{parent_id: string} | null} data */
                                data => {
                                    if (data.parent_id) {
                                        form.reset()
                                        document.querySelector('#modal').querySelector('[data-bs-dismiss]').click()
                                        selectParent(data.parent_id)
                                        ToastSuccess('Parent Added Successfully')
                                    } else {
                                        ToastError('Unable to add patient')
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