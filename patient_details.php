<!Doctype html>
<html lang="en">
<?php include 'partials/head.php'; ?>

<body>
<?php include 'partials/header.php' ?>
<?php global $errors, $db, $mail,
             $successes; ?>
<!----------------------------------------------------------------------------------->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['kid_id'])) {
        $kid_id = $_GET['kid_id'];
        [$result, $error] = $db->query("SELECT kids.name as kid_name, kids.category, kids.dob, parents.name as parent_name, parents.email, parents.address, parents.phone FROM kids JOIN parents ON kids.parent_id = parents.id WHERE kids.id = ?", $kid_id);
        if ($error) {
            array_push($errors, $error);
        } else {
            $kid = $result->first();
            if (!$kid) {
                array_push($errors, "No kid found with that id");
            }
        }
    } else {
        echo "No kid id provided";
    }
}
?>
<main class="d-flex">
    <?php include 'partials/aside.php'; ?>
    <div class="wrapper w-100" style="max-width: 1000px; margin: auto">
        <div class="chiclets">
            <a class="chiclet">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.9994 2V4H14.9994V7.24291C14.9994 8.40051 15.2506 9.54432 15.7357 10.5954L20.017 19.8714C20.3641 20.6236 20.0358 21.5148 19.2836 21.8619C19.0865 21.9529 18.8721 22 18.655 22H5.34375C4.51532 22 3.84375 21.3284 3.84375 20.5C3.84375 20.2829 3.89085 20.0685 3.98181 19.8714L8.26306 10.5954C8.74816 9.54432 8.99939 8.40051 8.99939 7.24291V4H7.99939V2H15.9994ZM13.3873 10.0012H10.6115C10.5072 10.3644 10.3823 10.7221 10.2371 11.0724L10.079 11.4335L6.12439 20H17.8734L13.9198 11.4335C13.7054 10.9691 13.5276 10.4902 13.3873 10.0012ZM10.9994 7.24291C10.9994 7.49626 10.9898 7.7491 10.9706 8.00087H13.0282C13.0189 7.87982 13.0119 7.75852 13.0072 7.63704L12.9994 7.24291V4H10.9994V7.24291Z"></path>
                    </svg>
                </div>
                <div class="title">Labs</div>
            </a>
            <a class="chiclet" href="patient_appointments.php?kid_id=<?php echo $kid_id ?>">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M7 3V1H9V3H15V1H17V3H21C21.5523 3 22 3.44772 22 4V9H20V5H17V7H15V5H9V7H7V5H4V19H10V21H3C2.44772 21 2 20.5523 2 20V4C2 3.44772 2.44772 3 3 3H7ZM17 12C14.7909 12 13 13.7909 13 16C13 18.2091 14.7909 20 17 20C19.2091 20 21 18.2091 21 16C21 13.7909 19.2091 12 17 12ZM11 16C11 12.6863 13.6863 10 17 10C20.3137 10 23 12.6863 23 16C23 19.3137 20.3137 22 17 22C13.6863 22 11 19.3137 11 16ZM16 13V16.4142L18.2929 18.7071L19.7071 17.2929L18 15.5858V13H16Z"></path>
                    </svg>
                </div>
                <div class="title">Appointments</div>
            </a>
            <a class="chiclet" href="prescriptions.php?patient_id=<?php echo $kid_id ?>">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19.7786 4.22184C22.1217 6.56498 22.1217 10.364 19.7786 12.7071L17.6565 14.8277L12.7075 19.7782C10.3643 22.1213 6.56535 22.1213 4.2222 19.7782C1.87906 17.435 1.87906 13.6361 4.2222 11.2929L11.2933 4.22184C13.6364 1.87869 17.4354 1.87869 19.7786 4.22184ZM14.8288 14.8284L9.17195 9.17158L5.63642 12.7071C4.07432 14.2692 4.07432 16.8019 5.63642 18.364C7.19851 19.9261 9.73117 19.9261 11.2933 18.364L14.8288 14.8284Z"></path>
                    </svg>
                </div>
                <div class="title">Prescriptions</div>
            </a>
            <a class="chiclet" href="patient_vaccinations.php?patient_id=<?php echo $kid_id ?>">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M21.6779 7.97918L20.2637 9.39339L18.1424 7.27207L16.021 9.39339L19.5566 12.9289L18.1424 14.3431L17.4353 13.636L11.0713 20H5.41444L3.29312 22.1213L1.87891 20.7071L4.00023 18.5858V12.9289L10.3642 6.56497L9.65708 5.85786L11.0713 4.44365L14.6068 7.97918L16.7281 5.85786L14.6068 3.73654L16.021 2.32233L21.6779 7.97918ZM16.021 12.2218L11.7784 7.97918L10.3642 9.39339L12.4855 11.5147L11.0713 12.9289L8.94997 10.8076L7.53576 12.2218L9.65708 14.3431L8.24287 15.7574L6.12155 13.636L6.00023 13.7574V18H10.2429L16.021 12.2218Z"></path>
                    </svg>
                </div>
                <div class="title">Vaccinations</div>
            </a>
            <style>
                .chiclets {
                    display: flex;
                    justify-content: space-between;
                    margin-bottom: 1rem;
                    margin-top: 3rem;
                }

                .chiclet {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    padding: 1rem;
                    border: 1px solid #e0e0e0;
                    border-radius: 5px;
                    cursor: pointer;
                    gap: 1rem;
                    background-color: #fff;
                    width: 200px;
                }

                .chiclet:hover {
                    background-color: #f5f5f5;
                }

                .chiclet .icon {
                    width: 2rem;
                    height: 2rem;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 50%;
                    background-color: #f5f5f5;
                }

                .chiclet .title {
                    font-size: 1.2rem;
                    font-weight: 500;
                }
            </style>
        </div>
        <div class="personal-info">
            <div class="parent-info">
                <div class="title">Parent Information</div>
                <div class="info">
                    <div class="label">Name</div>
                    <div class="value"><?php echo $kid->get('parent_name') ?></div>
                </div>
                <div class="info">
                    <div class="label">Email</div>
                    <div class="value"><?php echo $kid->get('email') ?></div>
                </div>
                <div class="info">
                    <div class="label">Address</div>
                    <div class="value"><?php echo $kid->get('address') ?></div>
                </div>
                <div class="info">
                    <div class="label">Phone</div>
                    <div class="value"><?php echo $kid->get('phone') ?></div>
                </div>
            </div>
            <div class="kid-info">
                <div class="title">Patient Information</div>
                <div class="info">
                    <div class="label">Name</div>
                    <div class="value"><?php echo $kid->get('kid_name') ?></div>
                </div>
                <div class="info">
                    <div class="label">Category</div>
                    <div class="value"><?php echo $kid->get('category') ?></div>
                </div>
                <div class="info">
                    <div class="label">Age</div>
                    <div class="value">
                        <?php
                        try {
                            $dob = new DateTime($kid->get('dob'));
                            $now = new DateTime();
                            $interval = $now->diff($dob);
                            echo $interval->y;
                        } catch (Exception $e) {
                            echo "Unknown";
                        }
                        ?>
                    </div>
                </div>
            </div>
            <style>
                .personal-info {
                    display: flex;
                    flex-direction: column;
                    gap: 1rem;
                    margin-bottom: 2rem;
                }

                .parent-info, .kid-info {
                    padding: 1rem;
                    border: 1px solid #e0e0e0;
                    border-radius: 5px;
                }

                .parent-info .title, .kid-info .title {
                    font-size: 1.2rem;
                    font-weight: 600;
                }

                .info {
                    display: flex;
                    gap: 1rem;
                    margin-bottom: 0.25rem;
                }

                .info .label {
                    font-weight: 500;
                    color: #333;
                }

                .info .value {
                    color: #666;
                }
            </style>
        </div>
        <div class="medical-history mt-4">
            <div class="medical-history-title">
                <div class="left">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16 2L20.9997 7L21 20.9925C21 21.5489 20.5551 22 20.0066 22H3.9934C3.44476 22 3 21.5447 3 21.0082V2.9918C3 2.44405 3.44749 2 3.9985 2H16ZM15 4H5V20H19V8H15V4ZM13 9V13H16V15H11V9H13Z"></path>
                        </svg>
                    </div>
                    History
                </div>
                <div class="right">
                    <button class="btn d-flex">
                        <span class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M17 2C17.5523 2 18 2.44772 18 3V7H21C21.5523 7 22 7.44772 22 8V18C22 18.5523 21.5523 19 21 19H18V21C18 21.5523 17.5523 22 17 22H7C6.44772 22 6 21.5523 6 21V19H3C2.44772 19 2 18.5523 2 18V8C2 7.44772 2.44772 7 3 7H6V3C6 2.44772 6.44772 2 7 2H17ZM16 17H8V20H16V17ZM20 9H4V17H6V16C6 15.4477 6.44772 15 7 15H17C17.5523 15 18 15.4477 18 16V17H20V9ZM8 10V12H5V10H8ZM16 4H8V7H16V4Z"></path>
                            </svg>
                        </span>
                        <span class="ml-2">Print</span>
                    </button>
                </div>
            </div>
            <div class="medical-history-body">
                <div class="medications">

                </div>
                <div class="allergies">

                </div>
                <div class="vaccinations">

                </div>
                <div class="labs">

                </div>
            </div>
            <style>
                .medical-history {
                    padding: 1rem;
                    border: 1px solid #e0e0e0;
                    border-radius: 5px;
                }

                .medical-history-title {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    gap: 1rem;
                    font-size: 1.2rem;
                    font-weight: 600;
                    margin-bottom: 1rem;
                }

                .medical-history-title .left {
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                    background-color: white;
                    width: fit-content;
                    padding: 0.5rem 1rem;
                }

                .medical-history-title .right {
                    display: flex;
                    align-items: center;
                    gap: 0.5rem;
                }

                .medical-history-title .right .btn {
                    padding: 0.5rem 1rem;
                    background-color: #007bff;
                    color: white;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }

                .medical-history-body {
                    display: flex;
                    flex-direction: column;
                    gap: 1rem;
                }

                .medications, .allergies, .vaccinations, .labs {
                    padding: 1rem;
                    border: 1px solid #e0e0e0;
                    border-radius: 5px;
                }
            </style>
        </div>
        <style>
            .icon {
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }
        </style>
    </div>
</main>

<!---------------------------------------------------------------------------------->
<?php include 'partials/footer.php'; ?>
</body>

</html>