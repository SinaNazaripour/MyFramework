<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;

class TemplateDataMiddleware implements MiddlewareInterface
{
    private array $data = [
        "title" => "MyFramework"
    ];
    public function __construct(private TemplateEngine $view) {}
    public function process(callable $next)
    {
        $this->view->addGlobalData($this->data);
        $next();
    }
}
