<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;

class ValidatorService
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    public function validateRegister($formData)
    {
        $this->validator->validate($formData);
    }
};
