<?php

declare(strict_types=1);

// namespace App;

require __DIR__ . "/../../vendor/autoload.php";


use Framework\App;
use App\Controllers\HomeController;
$app = new App();
$app->get("/",[HomeController::class,'home']);
$app->get("/god",[HomeController::class,'god']);

// $app->get("/home");


return $app;

// as you see ,the job of this file is prepare and return an instance of App (load  an configure the files necessery for our application)