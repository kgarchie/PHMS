<?php
if(file_exists("./.env")) {
    $lines = file("./.env", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach($lines as $line) {
        list($key, $value) = explode("=", $line, 2);
        $key = trim($key);
        $value = trim($value);
        putenv("$key=$value");
    }
} else {
    echo "No .env loaded";
}