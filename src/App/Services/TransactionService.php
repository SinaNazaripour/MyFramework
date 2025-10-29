<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;

class TransactionService
{
    public function __construct(private Database $db) {}

    public function createTransaction($data)
    {

        $formatedDate = "{$data['date']} 00:00:00";
        $query = "INSERT INTO transactions(user_id,amount,date,description) Values(:user_id , :amount, :date, :description )";
        $params = [
            'user_id' => $_SESSION['user'],
            'amount' => $data['amount'],
            'date' => $formatedDate,
            'description' => $data['description']
        ];
        $this->db->query($query, $params);
    }

    public function getUserTransactions($length, $offset)
    {
        $search = addcslashes($_GET['s'] ?? '', "%_");
        $params = ['user_id' => $_SESSION['user'], "searchQuery" => "%{$search}%"];
        $transactions = $this->db->query(
            "SELECT *,DATE_FORMAT(date,'%Y-%m-%h')AS f_date FROM transactions 
        WHERE user_id= :user_id AND description LIKE :searchQuery LIMIT {$length} OFFSET {$offset}",
            $params
        )->findAll();

        $count = $this->db->query("SELECT COUNT(*)FROM transactions 
        WHERE user_id= :user_id AND description LIKE :searchQuery", $params)->count();
        return [$transactions, $count];
    }
}
