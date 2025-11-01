<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ReceiptService, TransactionService};

class ReceiptController
{
    public function __construct(
        private TemplateEngine $view,
        private TransactionService $transactionService,
        private ReceiptService $receiptService
    ) {}

    public function uploadView(array $params)
    {
        $transaction = $this->transactionService->getUserTransaction($params['transaction']);

        if (!$transaction) {
            redirectTo("/");
        }

        echo $this->view->render("receipts/create.php");
    }

    public function upload(array $params)
    {
        $transaction = $this->transactionService->getUserTransaction($params['transaction']);

        if (!$transaction) {
            redirectTo("/");
        }

        $this->receiptService->vlidateFile($_FILES['receipt']);
        $this->receiptService->uploade($_FILES['receipt'], (int)$params['transaction']);

        redirectTo("/");
    }

    public function download(array $params)
    {
        $transaction = $this->transactionService->getUserTransaction($params['transaction']);
        if (empty($transaction)) {
            redirectTo("/");
        }

        $receipt = $this->receiptService->getReceipt($params['receipt']);
        if (empty($receipt) || (int) $receipt['transaction_id'] !== (int) $transaction['id'] || (int)$transaction['user_id'] !== (int) $_SESSION['user']) {
            redirectTo('/');
        }

        $this->receiptService->read($receipt);
    }
    public function delete(array $params) {}
}
