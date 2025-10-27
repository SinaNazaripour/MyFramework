<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;


class CsrfGuardMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        $validMethods = ['POST', 'PUT', 'DELETE'];
        $requestedMethod = strtoupper($_SERVER['REQUEST_METHOD']);
        if (!in_array($requestedMethod, $validMethods)) {
            $next();
            return;
        }

        if ($_POST['token'] !== $_SESSION['token']) {
            redirectTo('/');
            return;
        }
        unset($_SESSION['token']);
        $next();
    }
}
