<?php require_once 'utils/helpers.php'; ?>
<?php require_once 'db/DB.php'; ?>
<?php require_once 'mail/Mail.php'; ?>
<?php global $db;

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = $_GET['doctor_id'];
    $sql = "DELETE FROM doctors WHERE id = $id";
    [$result, $error] = $db->query($sql);
    if ($error) {
        echo json_error($error, 500);
    } else {
        echo json_encode([
            'message' => 'success'
        ]);
    }
} else {
    echo json_error("Method not allowed", 405);
}
?>