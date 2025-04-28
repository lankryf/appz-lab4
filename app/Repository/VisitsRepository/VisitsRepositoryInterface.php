<?php

namespace App\Repository\VisitsRepository;

use Bubblegum\Database\Model;
use Database\Models\Visits;

interface VisitsRepositoryInterface
{
    public function create(int $roomId, int $userId): Visits|Model;

    public function fetchAllVisitsByRoom(int $roomId): array;
}