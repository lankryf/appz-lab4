<?php

namespace App\Repository\VisitsRepository;

use Bubblegum\Database\Model;
use Database\Models\Visits;

class VisitsRepository implements VisitsRepositoryInterface
{
    public function create(int $roomId, int $userId): Visits|Model
    {
        return Visits::create([
            'quest_room_id' => $roomId,
            'user_id' => $userId,
        ]);
    }

    public function fetchAllVisitsByRoom(int $roomId): array
    {
        return (new Visits())
            ->where('quest_room_id', '=', $roomId)
            ->fetchAll() ?? [];
    }
}