<?php require_once 'utils/helpers.php'; ?>
<?php require_once 'db/DB.php'; ?>
<?php require_once 'mail/Mail.php'; ?>
<?php global $db;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search = $_POST['search_input'];
    [$result, $error] = $db->query("SELECT * FROM vaccines WHERE name LIKE ?", "%$search%");
    if ($error) {
        json_error($error, 500);
    } else {
        echo $result->toJson();
    }
}
?>