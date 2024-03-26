<?php require_once 'utils/helpers.php'; ?>
<?php require_once 'db/DB.php'; ?>
<?php require_once 'mail/Mail.php'; ?>
<?php global $db;
/**
 * Your PHP code here, it should echo a JSON response, and not output any HTML; The JSON response will be consumed asynchronously by the client
 * @example
 *if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 *  $search = $_POST['search_input'];
 *  [$result, $error] = $db->query("SELECT kids.name, kids.dob, kids.category, parents.name as parent_name, parents.id as parent_id FROM kids JOIN parents ON kids.parent_id = parents.id WHERE kids.name LIKE ?", "%$search%");
 *  if ($error) {
 *      json_error($error, 500);
 *  } else {
 *      echo $result->toJson();
 *  }
 * }
 */


// Your php code here
?>