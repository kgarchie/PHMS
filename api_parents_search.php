<?php require_once 'utils/helpers.php'; ?>
<?php require_once 'db/DB.php'; ?>
<?php require_once 'mail/Mail.php'; ?>
<?php global $db;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['search_input'])) {
        return json_error("No search input provided", 400);
    }

    $search = $_POST['search_input'];
    [$result, $error] = $db->query("SELECT parents.id, parents.name, parents.email, parents.phone, parents.address FROM parents WHERE parents.name LIKE ? OR parents.email LIKE ? OR parents.phone LIKE ?", "%$search%", "%$search%", "%$search%");
    if ($error) {
        return json_error($error, 500);
    }

    echo $result->toJson();
}
?>