<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\TransactionService;

class HomeController

{

    public function __construct(private TemplateEngine $view, private TransactionService $transactionService) {}
    public function home()
    {
        $searchTerm = $_GET['s'] ?? null;
        $page = $_GET['p'] ?? 1;
        $page = (int) $page ?? 1;
        $length = 5;
        $offset = ($page - 1) * $length;
        [$transactions, $count] = $this->transactionService->getUserTransactions($length, $offset);

        $numPages = $count ? range(1, ceil($count / $length)) : [1];
        $pageList = array_map(fn($number) => http_build_query(['p' => $number, 's' => $searchTerm]), $numPages);
        echo $this->view->render("/index.php", [
            "title" => "home",

            "transactions" => $transactions,

            "currentPage" => $page,

            "previousPageQuery" => http_build_query([
                "p" => $page - 1,
                "s" => $searchTerm,
            ]),

            "lastPage" => ceil($count / $length),

            "pageList" => $pageList,

            "nextPageQuery" => http_build_query([
                "p" => $page + 1,
                "s" => $searchTerm,
            ]),
        ]);
    }
}
