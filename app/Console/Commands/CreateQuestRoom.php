<?php

namespace App\Console\Commands;

use Bubblegum\Candyman\Command;
use Bubblegum\Candyman\Console;
use Bubblegum\Database\DB;
use Database\Models\QuestRoom;

class CreateQuestRoom extends Command
{
    protected string $info = 'create quest room';

    protected array $argsNames = ['name', 'open_hour', 'close_hour', 'price', 'max_players'];

    public function handle($args): void
    {
        DB::initPDO();
        QuestRoom::create([
            'name' => $args[0],
            'open_hour' => (int)$args[1],
            'close_hour' => (int)$args[2],
            'price' => (float)$args[3],
            'max_players' => (int)$args[4],
        ]);
        Console::info('created');
    }

}