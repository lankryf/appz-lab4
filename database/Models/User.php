<?php

namespace Database\Models;

use Bubblegum\Database\Model;

class User extends Model
{
    protected $tableName = 'users';

    public function getId(): int|null
    {
        return $this->id;
    }
}