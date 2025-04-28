<?php

namespace App\Repository\UserRepository;

use Bubblegum\Database\Model;
use Database\Models\User;

interface UsersRepositoryInterface
{
    public function create(string $login): User|Model;

    public function getFirstByLogin(string $login): User|Model;
}