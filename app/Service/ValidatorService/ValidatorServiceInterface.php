<?php

namespace App\Service\ValidatorService;

interface ValidatorServiceInterface
{
    public function toInt(string $name, string|null $value): int;

    public function toFloat(string $name, string|null $value): float;
}