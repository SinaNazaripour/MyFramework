<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\{DateFormatRule, RequiredRule, EmailRule, MinRule, InRule, UrlRule, MatchRule, MaxLengthRule, NumericRule};

class ValidatorService
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->validator->add("required", new RequiredRule());
        $this->validator->add("email", new EmailRule());
        $this->validator->add("min", new MinRule());
        $this->validator->add("in", new InRule());
        $this->validator->add("url", new UrlRule());
        $this->validator->add("match", new MatchRule());
        $this->validator->add("max", new MaxLengthRule());
        $this->validator->add("numericOnly", new NumericRule());
        $this->validator->add("dateFormat", new DateFormatRule());
    }

    public function validateRegister($formData)
    {
        $this->validator->validate($formData, [
            "email" => ["required", "email"],
            "age" => ["required", "min:20"],
            "country" => ["required", "in:USA,Canada"],
            "socialMedia" => ["required", 'url'],
            "password" => ["required"],
            "confirmPassword" => ["required", 'match:password'],
            "sto" => ["required"],
        ]);
    }
    public function validateLogin(array $formData)
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
    }

    public function validateTransaction($formData)
    {
        $this->validator->validate($formData, [
            "amount" => ['required', 'numericOnly'],
            "date" => ['required', 'dateFormat:Y-m-d'],
            "description" => ['required', 'max:255']
        ]);
    }
};
