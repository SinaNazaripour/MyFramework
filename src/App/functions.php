<?php

declare(strict_types=1);

// namespace App;

function dd(mixed $value = "None")
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

function e($value): string
{
    return htmlspecialchars((string) $value);
}

function redirectTo(string $path)
{

    header("Location:{$path}");
    http_response_code(302);
    exit;
}
