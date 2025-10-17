<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;

class AuhtController

{

    public function __construct(private TemplateEngine $view) {}
    public function registerView()
    {
        echo $this->view->render("/register.php");
    }

    public function register()
    {
        $data = $_POST;
        dd($data);
    }
}
