<?php require_once 'utils/helpers.php'; ?>
<?php require_once 'db/DB.php'; ?>
<?php require_once 'mail/Mail.php'; ?>
<?php global $db;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['name']) || !isset($_POST['description'])) {
        echo json_error("Name and description are required", 400);
        return;
    }
    $name = $_POST['name'];
    $description = $_POST['description'];
    [$result, $error] = $db->query("INSERT INTO vaccines (name, description) VALUES (?, ?)", $name, $description);
    if ($error) {
        echo json_error($error, 500);
        return;
    }

    echo json_encode(['success' => true, 'message' => 'Vaccine added successfully']);
}
?>