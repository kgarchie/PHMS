<?php require_once 'utils/helpers.php'; ?>
<?php require_once 'db/DB.php'; ?>
<?php require_once 'mail/Mail.php'; ?>
<?php global $db;

function getDoctor($id)
{
    global $db;
    [$doctor, $error] = $db->query("SELECT * FROM doctors WHERE id = ?", $id);
    if ($error) {
        return null;
    }

    return $doctor->first();
}


if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $doctor_id = $_GET['doctor_id'];
    $doctor = getDoctor($doctor_id);
    if ($doctor) {
        echo $doctor->toJson();
    } else {
        echo json_encode(array('error' => 'Doctor not found'));
    }
} else {
    echo json_encode(array('error' => 'Invalid request method'));
}
?>