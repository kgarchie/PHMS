<?php require_once 'utils/helpers.php'; ?>
<?php require_once 'db/DB.php'; ?>
<?php require_once 'mail/Mail.php'; ?>
<?php global $db;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['search_input'])) {
        return json_error("No search input provided", 400);
    }

    $search = $_POST['search_input'];
    [$result, $error] = $db->query("SELECT kids.id as kid_id, kids.name, kids.dob, kids.category, parents.name as parent_name, parents.id as parent_id, parents.email FROM kids JOIN parents ON kids.parent_id = parents.id WHERE kids.name LIKE ?", "%$search%");
    if ($error) {
        return json_error($error, 500);
    }

    echo $result->toJson();
}
?>