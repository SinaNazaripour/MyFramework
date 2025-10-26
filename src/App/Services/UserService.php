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

    // public function isUserExist(string $email)
    // {
    //     $query = "SELECT COUNT(*) FROM users WHERE email= :email";
    //     $params = [
    //         'email' => $email
    //     ];
    //     $userCount = $this->db->query($query, $params)->count();
    //     if ($userCount < 1) {
    //         throw new ValidationException(["password" => ["Invalid credentials"]]);
    //     }
    // }

    // public function checkPassword($formData)
    // {
    //     $query = "SELECT password FROM users WHERE email= :email";
    //     $params = [
    //         'email' => $formData['email']
    //     ];

    //     $password = $this->db->query($query, $params)->find()['password'];
    //     // dd($password);
    //     dd(password_verify($formData['password'], $password));
    // }
    public function login($formData)
    {
        $query = "SELECT id,email,password FROM users WHERE email= :email";
        $params = [
            'email' => $formData['email']
        ];

        $user = $this->db->query($query, $params)->find();

        $passwordMatch = password_verify($formData['password'], $user['password']);

        if (!$user || !$passwordMatch) {
            throw new ValidationException(["password" => ["Invalid credentials"]]);
        }

        session_regenerate_id();
        $_SESSION['user'] = $user['id'];
    }
}
