<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;
use App\Services\ValidatorService;

class AuhtController

{

    public function __construct(private TemplateEngine $view, private ValidatorService $validatorService) {}
    public function registerView()
    {
        echo $this->view->render("/register.php");
    }

    public function register()
    {
        $data = $_POST;
        $this->validatorService->validateRegister($data);
    }
}
