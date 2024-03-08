<?php

function redirect($location)
{
    header("Location: $location");
}

function setAuthCookie($value, ...$options)
{
    setcookie("auth", $value, $options);
}

function removeAuthCookie()
{
    setcookie("auth", "", time() - 3600);
}

function getAuthCookie(): ?string
{
    $cookie = $_COOKIE['auth'] ?? null;
    if (!$cookie) return null;

    // TODO: Check db

    $cookie = trim($cookie);

    if (empty($cookie)) return null;
    return $cookie;
}

function authenticate($email, $password): ?string
{
    global $errors, $db;
    [$result, $error] = $db->query("SELECT * FROM users WHERE `email` = ?", $email);

    if ($error) {
        array_push($errors, $error);
        return null;
    }

    $user = $result->first();
    if (!$user) {
        array_push($errors, "Invalid Email or Password");
        return null;
    };

    $verified = password_verify($password, $user->get('password'));
    if (!$verified) {
        array_push($errors, "Invalid Email or Password");
        return null;
    }

    $user_id = $user->get('id');
    $token = uniqid();
    [$_, $error] = $db->query("INSERT INTO tokens (`user_id`, `token`) VALUES (?, ?)", $user_id, $token);
    if ($error) {
        array_push($errors, $error);
        return null;
    }

    return $token;
}

function getOrigin(): string
{
    if (array_key_exists('HTTP_ORIGIN', $_SERVER)) {
        return $_SERVER['HTTP_ORIGIN'];
    } else if (array_key_exists('HTTP_REFERER', $_SERVER)) {
        return $_SERVER['HTTP_REFERER'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

function generateToken($email): ?string
{
    global $errors, $db;
    if(!isset($email)) {
        array_push($errors, "No email provided for token generation");
        return null;
    }

    [$result, $error] = $db->query("SELECT * FROM users WHERE `email` = ?", $email);
    if ($error) {
        array_push($errors, $error);
        return null;
    }

    $user = $result->first();
    if (!$user) {
        array_push($errors, "No user found with that email");
        return null;
    }

    $token = uniqid();
    [$_, $error] = $db->query("INSERT INTO tokens (`user_id`, `token`) VALUES (?, ?)", $user->get('id'), $token);
    if ($error) {
        array_push($errors, $error);
        return null;
    }

    return $token;
}
