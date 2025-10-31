<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;
use App\Config\Paths;

class ReceiptService
{
    public function __construct(private Database $db) {}

    public function vlidateFile(array $file)
    {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            throw new ValidationException(["receipt" => ['Uploade failed']]);
        }

        $maxFileSizeMB = 3 * 1024 * 1024;
        if ($file['size'] > $maxFileSizeMB) {
            throw new ValidationException(["receipt" => ['Uploaded file is too large try a file under 3MB']]);
        }

        $originalFileName = $file['name'];
        if (!preg_match("/^[a-zA-Z0-9\s._-]+$/", $originalFileName)) {
            throw new ValidationException(["receipt" => ['Invalid fileName']]);
        }

        $clientMimeType = $file['type'];
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];

        if (!in_array($clientMimeType, $allowedTypes)) {
            throw new ValidationException(["receipt" => ['try image or pdf']]);
        }
    }

    public function uploade(array $file, int $transaction_id)
    {
        $ex = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newFileName = bin2hex(random_bytes(16)) . "." . $ex;
        $uploadePath = Paths::STORAGE_UPLOADES . "/" . $newFileName;

        if (!move_uploaded_file($file['tmp_name'], $uploadePath)) {
            throw new ValidationException(["receipt" => ['Uploade failed']]);
        }

        $this->db->query(
            "INSERT INTO receipts(transaction_id,original_filename,storage_filename,media_type)
            VALUES(:transaction_id,:original_filename,:storage_filename,:media_type)",
            [
                "transaction_id" => $transaction_id,
                "original_filename" => $file['name'],
                "storage_filename" => $newFileName,
                "media_type" => $file['type']
            ]
        );
    }
}
