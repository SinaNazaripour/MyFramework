<?php

declare(strict_types=1);

// namespace App;

require __DIR__ . "/../../vendor/autoload.php";


use Framework\App;

$app = new App();
$app->get("/");
$app->get("/home");

dd($app);
return $app;

// as you see ,the job of this file is prepare and return an instance of App (load  an configure the files necessery for our application)