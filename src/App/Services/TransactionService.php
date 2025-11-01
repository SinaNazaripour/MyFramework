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
            "SELECT *,DATE_FORMAT(date,'%Y-%m-%d')AS f_date FROM transactions 
        WHERE user_id= :user_id AND description LIKE :searchQuery LIMIT {$length} OFFSET {$offset}",
            $params
        )->findAll();
        $transactions = array_map(
            function ($transaction) {
                $transaction['receipts'] = $this->db->query(
                    "SELECT * FROM receipts WHERE transaction_id= :transaction_id",
                    ["transaction_id" => $transaction["id"]]
                )->findAll();

                return $transaction;
            },
            $transactions
        );

        $count = $this->db->query("SELECT COUNT(*)FROM transactions 
        WHERE user_id= :user_id AND description LIKE :searchQuery", $params)->count();
        return [$transactions, $count];
    }

    public function getUserTransaction($id)
    {
        return $this->db->query("SELECT *,DATE_FORMAT(date,'%Y-%m-%d')AS f_date FROM transactions WHERE id =:id AND user_id= :user_id", ["id" => $id, "user_id" => $_SESSION['user']])->find();
    }

    public function updateTransaction($formData, $id)
    {
        $formatted_date = "{$formData['date']} 00:00:00";

        $this->db->query(
            "UPDATE transactions SET amount=:amount,date=:date,description=:description WHERE id=:id AND user_id=:user_id",
            ["id" => $id, "user_id" => $_SESSION['user'], "amount" => $formData['amount'], "date" => $formatted_date, "description" => $formData['description']]
        );
    }

    public function deleteTransaction($id)
    {
        $this->db->query("DELETE FROM transactions WHERE id=:id AND user_id=:user_id", ["id" => $id, "user_id" => $_SESSION['user']]);
    }
}
