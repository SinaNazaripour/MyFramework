<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class MaxLengthRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        if (empty($params[0])) {
            throw new InvalidArgumentException("maxlength not specified");
        }

        $length = strlen($data[$field]);
        return (bool)($length < (int)$params[0]);
    }

    public function getMessage(array $data, string $field, array $params): string
    {
        return "max length is {$params[0]}";
    }
}
