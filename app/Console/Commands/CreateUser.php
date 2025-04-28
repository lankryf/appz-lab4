<?php

namespace App\Console\Commands;

use App\Exceptions\ValidationException;
use App\Repository\QuestRoomsRepository\QuestRoomsRepository;
use App\Repository\UserRepository\UsersRepository;
use App\Service\ValidatorService\ValidatorService;
use Bubblegum\Candyman\Command;
use Bubblegum\Candyman\Console;
use Bubblegum\Database\DB;
use Database\Models\User;

class CreateUser extends Command
{
    protected string $info = 'prints bubblegum info';

    protected array $argsNames = ['login'];

    public function handle($args): void
    {
        DB::initPDO();
        if (count($args) != count($this->argsNames))
        {
            Console::error('Invalid arguments count');
            return;
        }
        (new UsersRepository())->create(
            $args[0]
        );
        Console::done('User has been created!');
    }

}