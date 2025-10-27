<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\ValidationException;


class ValidationExceptionMiddleware implements MiddlewareInterface
{

    public function process(callable $next)
    {
        try {
            $next();
        } catch (ValidationException $e) {
            // dd($e->errors);
            $_SESSION['errors'] = $e->errors;
            $_SESSION['oldForm'] = $_POST;
            $referer = ($_SERVER['HTTP_REFERER']);

            if (parse_url($referer, PHP_URL_HOST) !== $_SERVER['HTTP_HOST']) {
                $referer = '/';
            }
            redirectTo("$referer");
        }
    }
}
