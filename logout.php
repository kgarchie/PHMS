<?php
function logout()
{
    global $errors, $db;
    try{
        $db->query("UPDATE sessions SET `is_valid` = false WHERE `token` = ?", getAuthCookie());
        removeAuthCookie();
        redirect("/login.php");
    } catch (Exception $e) {
        echo "Unknown Error Occurred";
        array_push($errors, "Unknown Error Occurred While Logging Out");
    }
}

logout();
