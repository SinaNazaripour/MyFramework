<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\{RequiredRule};

class ValidatorService
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->validator->add("required", new RequiredRule());
    }

    public function validateRegister($formData)
    {
        $this->validator->validate($formData, [
            "email" => ["required"],
            "age" => ["required"],
            "country" => ["required"],
            "socialMedia" => ["required"],
            "password" => ["required"],
            "confirmPassword" => ["required"],
            "sto" => ["required"],
        ]);
    }
};
