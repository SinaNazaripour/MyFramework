<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\TemplateEngine;
use Framework\Contracts\MiddlewareInterface;

class FlashMiddleware implements MiddlewareInterface
{
    public function __construct(public TemplateEngine $view) {}
    public function process(callable $next)
    {
        $packet = [
            "errors" => $_SESSION["errors"] ?? []
        ];
        $this->view->addGlobalData($packet ?? []);
        $next();
    }
}
