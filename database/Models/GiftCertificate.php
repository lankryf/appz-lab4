<?php

namespace Database\Models;

use Bubblegum\Database\Model;

class GiftCertificate extends Model
{
    protected $tableName = 'gift_certificates';

    public function getId(): int|null
    {
        return $this->id;
    }
    public function getCode(): string|null
    {
        return $this->code;
    }
    public function getUsed(): bool|null
    {
        return $this->used;
    }
    public function setUsed(bool $used): void
    {
        $this->used = (string)$used;
    }
}