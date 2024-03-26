<?php require_once 'utils/helpers.php'; ?>
<?php require_once 'db/DB.php'; ?>
<?php require_once 'mail/Mail.php'; ?>
<?php global $db;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['search_input'])) {
        return json_error("No search input provided", 400);
    }

    $search = $_POST['search_input'];
    // TODO: Show only available doctors.
    [$result, $error] = $db->query("SELECT doctors.id, doctors.name, doctors.email, doctors.phone FROM doctors WHERE doctors.name LIKE ? OR doctors.email LIKE ? OR doctors.phone LIKE ?", "%$search%", "%$search%", "%$search%");
    if ($error) {
        return json_error($error, 500);
    }

    echo $result->toJson();
}
?>