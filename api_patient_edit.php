<?php require_once 'utils/helpers.php'; ?>
<?php require_once 'db/DB.php'; ?>
<?php require_once 'mail/Mail.php'; ?>
<?php global $db;

function updatePatient($name, $dob, $category, $id){
    global $db;
    [$result, $error] = $db->query("UPDATE kids SET name = ?, dob = ?, category = ? WHERE id = ?", $name, $dob, $category, $id);
    if($error){
        return json_error($error, 500);
    }

    return null;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['patient_name']) && isset($_POST['patient_dob']) && isset($_POST['patient_category']) && isset($_POST['patient_id'])){
        $error = updatePatient($_POST['patient_name'], $_POST['patient_dob'], $_POST['patient_category'], $_POST['patient_id']);
        if($error != null){
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