<?php

namespace App\Repository\UserRepository;

use Bubblegum\Database\Model;
use Database\Models\User;

class UsersRepository implements UsersRepositoryInterface
{
    public function create(string $login): User|Model
    {
        return User::create([
            'login' => $login,
        ]);
    }

    public function getFirstByLogin(string $login): User|Model
    {
        return (new User())->where('login', '=', $login)->first();
    }
}