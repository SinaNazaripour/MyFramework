<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;

class AuthRequireMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        if (empty($_SESSION['user'])) {
            redirectTo('/login');
        }
        $next();
    }
}
