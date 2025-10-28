<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\TransactionService;
use App\Services\ValidatorService;
use Framework\TemplateEngine;



class TransactionController
{

    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validatorService,
        private TransactionService $transactionService,
    ) {}

    public function createView()
    {

        echo $this->view->render("transactions/createForm.php", ['title' => 'transactions|create']);
    }

    public function create()
    {
        $data = $_POST;

        $this->validatorService->validateTransaction($data);
        $this->transactionService->createTransaction($data);
        redirectTo('/');
        return;
    }
}
