<?php require_once 'utils/helpers.php'; ?>
<?php require_once 'db/DB.php'; ?>
<?php require_once 'mail/Mail.php'; ?>
<?php global $db;
function updateDoctor($name, $email, $phone, $address, $id)
{
    global $db;
    if (!$id) return json_error("Doctor ID is required", 400);
    [$_, $error] = $db->query("UPDATE doctors SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?", $name, $email, $phone, $address, $id);
    if ($error) {
        return json_error($error, 500);
    }

    return null;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['doctor_name']) && isset($_POST['doctor_email']) && isset($_POST['doctor_phone']) && isset($_POST['doctor_address']) && isset($_POST['doctor_id'])) {
        $error = updateDoctor($_POST['doctor_name'], $_POST['doctor_email'], $_POST['doctor_phone'], $_POST['doctor_address'], $_POST['doctor_id']);
        if ($error) {
            echo json_error($error, 500);
        } else {
            echo json_encode([
                'message' => 'success'
            ]);
        }
    } else {
        echo json_error("All fields are required", 400);
    }
}
?>