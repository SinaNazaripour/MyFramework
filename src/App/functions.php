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
