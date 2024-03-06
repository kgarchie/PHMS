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
