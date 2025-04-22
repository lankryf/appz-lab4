<?php

namespace App\Console\Commands;

use Bubblegum\Candyman\Command;
use Bubblegum\Candyman\Console;
use Bubblegum\Database\DB;
use Database\Models\QuestRoom;

class GetQuestRooms extends Command
{
    protected string $info = 'creating gift certificate';

    protected array $argsNames = ['from_hour', 'to_hour'];

    public function handle($args): void
    {
        DB::initPDO();
        $rooms = (new QuestRoom())
            ->where('open_hour', '>=', $args[0] ?? 0)
            ->where('close_hour', '<=', $args[1] ?? 24)
            ->get();
        foreach ($rooms as $room) {
            Console::info("id={$room->getId()} name={$room->getName()} price={$room->getPrice()} max_players={$room->getMaxPlayers()} open_hour={$room->getOpenHour()} close_hour={$room->getCloseHour()}");
        }
    }

}