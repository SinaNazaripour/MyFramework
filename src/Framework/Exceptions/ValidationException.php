<?php

declare(strict_types=1);

namespace Framework\Exceptions;

use RuntimeException;


class ValidationException extends RuntimeException
{
    public function __constract(int $code = 422)
    {
        parent::__construct(code: $code);
    }
}
