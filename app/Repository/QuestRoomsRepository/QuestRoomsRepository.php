<?php

namespace App\Repository\QuestRoomsRepository;

use Bubblegum\Database\Model;
use Database\Models\QuestRoom;

class QuestRoomsRepository
{
    public function create(string $name, int $openHour, int $closeHour, float $price, int $maxPlayers): QuestRoom|Model
    {
        return QuestRoom::create([
            'name' => $name,
            'open_hour' => $openHour,
            'close_hour' => $closeHour,
            'price' => $price,
            'max_players' => $maxPlayers,
        ]);
    }

    public function getByTime(int $openHour = 0, int $closeHour = 24): QuestRoom|Model
    {
        return (new QuestRoom())
            ->where('open_hour', '>=', $openHour)
            ->where('close_hour', '<=', $closeHour)
            ->get();
    }

    public function getById(int $id): QuestRoom|Model
    {
        return QuestRoom::find($id);
    }
}