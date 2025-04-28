<?php

namespace App\Service\ValidatorService;

use App\Exceptions\ValidationException;
use Bubblegum\Candyman\Console;

class ValidatorService implements ValidatorServiceInterface
{
    public function toInt(string $name, string|null $value): int
    {
        $result = filter_var($value, FILTER_VALIDATE_INT);
        if ($result === false || is_null($value)) {
            throw new ValidationException("$name must be integer");
        }
        return $result;
    }

    public function toFloat(string $name, string|null $value): float
    {
        $result = filter_var($value, FILTER_VALIDATE_FLOAT);
        if ($result === false || is_null($value)) {
            throw new ValidationException("$name must be float");
        }
        return $result;
    }
}