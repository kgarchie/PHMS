<?php require_once 'utils/helpers.php'; ?>
<?php require_once 'db/DB.php'; ?>
<?php require_once 'mail/Mail.php'; ?>
<?php global $db;
function addParent($parent_name, $parent_email, $phone, $address)
{
    global $db;
    [$_, $error] = $db->query("INSERT INTO parents (`name`, `email`, `phone`, `address`) VALUES (?, ?, ?, ?)", $parent_name, $parent_email, $phone, $address);
    if ($error) {
        return null;
    }

    [$parent, $error] = $db->query("SELECT parents.id FROM parents WHERE email = ?", $parent_email);
    if ($error) {
        return null;
    }

    return $parent->first()->get('id');
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['parent_name']) || !isset($_POST['parent_email']) || !isset($_POST['address']) || !isset($_POST['phone'])) {
        echo json_error("All fields are required", 400);
        return;
    }

    $parent_name = $_POST['parent_name'];
    $parent_email = $_POST['parent_email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $parent_id = addParent($parent_name, $parent_email, $phone, $address);

    if ($parent_id) {
        echo json_encode(['parent_id' => $parent_id]);
    } else {
        echo json_error("Failed to add parent", 500);
    }
}
?>