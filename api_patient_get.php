<?php require_once 'utils/helpers.php'; ?>
<?php require_once 'db/DB.php'; ?>
<?php require_once 'mail/Mail.php'; ?>
<?php global $db;
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['patient_id'];
    $sql = "SELECT * FROM kids WHERE id = $id";
    [$result, $error] = $db->query($sql);
    if ($error) {
        echo json_error($error, 500);
    } else {
        echo $result->first()->toJson();
    }
} else {
    echo json_error("Method not allowed", 405);
}
?>