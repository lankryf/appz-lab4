<?php

namespace App\Console\Commands;

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
        User::create([
            'login' => $args[0],
        ]);
        Console::info('created');
    }

}