<?php

namespace Database\Models;

use Bubblegum\Database\Model;

class QuestRoom extends Model
{
    protected $tableName = 'quest_rooms';

    public function getId(): int|null
    {
        return $this->id;
    }

    public function getName(): string|null
    {
        return $this->name;
    }
    public function getPrice(): int|null
    {
        return $this->price;
    }

    public function getOpenHour(): int|null
    {
        return $this->open_hour;
    }
    public function getCloseHour(): int|null
    {
        return $this->close_hour;
    }
    public function getMaxPlayers(): int|null
    {
        return $this->max_players;
    }
}