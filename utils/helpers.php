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

    $cookie = trim($cookie);

    if (empty($cookie)) return null;
    return $cookie;
}

function value_or_error(callable $func): array
{
    try {
        $result = $func();
        return [$result, null];
    } catch (Exception $e) {
        return [null, $e->getMessage()];
    }
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