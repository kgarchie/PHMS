<?php
require_once('./database/db.php');
$db = new DB('./database/phms.db');
if(!$db) {
    die("SQLiteDatabase Error: " . $db->lastErrorMsg());
};
$sql = file_get_contents('./database/schema.sql');
$db->query($sql);
