<?php require_once 'utils/helpers.php'; ?>
<?php require_once 'db/DB.php'; ?>
<?php require_once 'mail/Mail.php'; ?>
<?php global $db;

function updatePatient($name, $dob, $parent_id, $category){
    global $db;
    [$result, $error] = $db->query("UPDATE kids SET name = ?, dob = ?, parent_id = ?, category = ?", $name, $dob, $parent_id, $category);
    if($error){
        return json_error($error, 500);
    }

    return null;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['patient_name']) && isset($_POST['patient_dob']) && isset($_POST['patient_parent_id']) && isset($_POST['patient_category'])){
        $error = updatePatient($_POST['patient_name'], $_POST['patient_dob'], $_POST['patient_parent_id'], $_POST['patient_category']);
        if($error){
            echo $error;
        } else {
            echo json_encode([
                'message' => 'success'
            ]);
        } 
    }
}
?>