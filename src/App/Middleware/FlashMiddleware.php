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
        unset($_SESSION['errors']);

        if (array_key_exists('oldForm', $_SESSION)) {
            $oldForm = $_SESSION['oldForm'];
            $escaped = ['password', 'confirmPassword'];
            $oldForm = ['oldForm' => array_diff_key($oldForm, array_flip($escaped))];

            $this->view->addGlobalData($oldForm);
        }
        unset($_SESSION['oldForm']);
        $next();
    }
}
