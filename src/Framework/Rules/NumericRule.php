<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;


class NumericRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        return (bool)(is_numeric($data[$field]));
    }

    public function getMessage(array $data, string $field, array $params): string
    {
        return "try a valid number";
    }
}
