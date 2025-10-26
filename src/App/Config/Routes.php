<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Controllers\{HomeController, AboutController, AuhtController};


function registerRoutes(App $app)
{
    $app->get("/", [HomeController::class, 'home']);
    $app->get("/about", [AboutController::class, 'about']);
    $app->get("/register", [AuhtController::class, 'registerView']);
    $app->post("/register", [AuhtController::class, 'register']);
    $app->get('/login', [AuhtController::class, 'loginView']);
    $app->post('/login', [AuhtController::class, 'login']);
}
