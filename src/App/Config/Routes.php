<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Controllers\{HomeController, AboutController, AuhtController, ReceiptController, TransactionController};
use App\Middleware\{AuthRequireMiddleware, GuestOnlyMiddleware};

function registerRoutes(App $app)
{
    $app->get("/", [HomeController::class, 'home'])->protect(AuthRequireMiddleware::class);
    $app->get("/about", [AboutController::class, 'about']);
    $app->get("/register", [AuhtController::class, 'registerView'])->protect(GuestOnlyMiddleware::class);
    $app->post("/register", [AuhtController::class, 'register']);
    $app->get('/login', [AuhtController::class, 'loginView'])->protect(GuestOnlyMiddleware::class);
    $app->post('/login', [AuhtController::class, 'login'])->protect(GuestOnlyMiddleware::class);
    $app->get('/logout', [AuhtController::class, 'logout'])->protect(AuthRequireMiddleware::class);
    $app->get('/transaction', [TransactionController::class, 'createView'])->protect(AuthRequireMiddleware::class);
    $app->post('/transaction', [TransactionController::class, 'create'])->protect(AuthRequireMiddleware::class);
    $app->get('/transaction/{transaction}', [TransactionController::class, 'editView'])->protect(AuthRequireMiddleware::class);
    $app->post('/transaction/{transaction}', [TransactionController::class, 'edit'])->protect(AuthRequireMiddleware::class);
    $app->delete('/transaction/{transaction}', [TransactionController::class, 'delete'])->protect(AuthRequireMiddleware::class);
    $app->get('/transaction/{transaction}/receipt', [ReceiptController::class, 'uploadView'])->protect(AuthRequireMiddleware::class);
    $app->post('/transaction/{transaction}/receipt', [ReceiptController::class, 'upload'])->protect(AuthRequireMiddleware::class);
    $app->get('transaction/{transaction}/receipt/{receipt}', [ReceiptController::class, 'download']);
    $app->delete('transaction/{transaction}/receipt/{receipt}', [ReceiptController::class, 'delete']);
}
