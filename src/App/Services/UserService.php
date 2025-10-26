<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Exceptions\ValidationException;

class UserService
{
    public function __construct(private Database $db) {}

    public function isEmailTaken(string $email)
    {
        $emailCount = $this->db->query(
            "SELECT COUNT(*) FROM users WHERE email= :email",
            ["email" => $email]
        )->count();

        if ($emailCount > 0) {
            throw new ValidationException(["email" => ["email is already taken"]]);
        }
    }

    public function create($data)
    {
        $password = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        $query = 'INSERT INTO users (email,password,age,country,social_media_url) VALUES(:email,:password,:age,:country,:social_media_url)';
        $this->db->query($query, [
            'email' => $data['email'],
            'password' => $password,
            'age' => $data['age'],
            'country' => $data['country'],
            'social_media_url' => $data['socialMedia'],
        ]);
    }
}
