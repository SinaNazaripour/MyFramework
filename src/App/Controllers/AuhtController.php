<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;
use App\Services\UserService;
use App\Services\ValidatorService;

class AuhtController

{

    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validatorService,
        private UserService $userService
    ) {}
    public function registerView()
    {
        echo $this->view->render("/register.php");
    }

    public function register()
    {
        $data = $_POST;
        $this->validatorService->validateRegister($data);
        $this->userService->isEmailTaken($data['email']);
        $this->userService->create($data);
        redirectTo("/");
    }

    public function loginView()
    {
        echo $this->view->render('login.php', ['title' => 'login']);
    }

    public function login()
    {
        $data = $_POST;
        $this->validatorService->validateLogin($data);
        // $this->userService->isUserExist($data['email']);
        // $this->userService->checkPassword($data);
        $this->userService->login($data);

        redirectTo('/');
    }

    public function logout()
    {
        $this->userService->logout();

        redirectTo('/login');
    }
}
