<?php
require_once "db/DB.php";
require_once "utils/helpers.php";

function logout()
{
    global $errors, $db;
    try{
        [$_, $error] = $db->query("UPDATE tokens SET `is_valid` = false WHERE `token` = ?", getAuthCookie());
        if ($error) return array_push($errors, $error);
        removeAuthCookie();
        redirect("/login.php");
    } catch (Exception $e) {
        array_push($errors, "Unknown Error Occurred While Logging Out");
    }
}

logout();
