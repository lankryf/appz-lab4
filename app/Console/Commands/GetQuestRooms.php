<?php

namespace App\Console\Commands;

use App\Exceptions\ValidationException;
use App\Repository\QuestRoomsRepository\QuestRoomsRepository;
use App\Repository\VisitsRepository\VisitsRepository;
use App\Service\ValidatorService\ValidatorService;
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
        if (count($args) != count($this->argsNames))
        {
            Console::error('Invalid arguments count');
            return;
        }
        $validatorService = new ValidatorService();
        try {
            $openHour = $validatorService->toInt($this->argsNames[0], $args[0]);
            $closeHour = $validatorService->toInt($this->argsNames[1], $args[1]);

        } catch (ValidationException $exception) {
            Console::error($exception->getMessage());
            return;
        }
        $rooms = (new QuestRoomsRepository())->getByTime($openHour, $closeHour);
        $count = 0;

        $visitsRepository = new VisitsRepository();

        foreach ($rooms as $room) {
            $visitsLeft = $room->getMaxPlayers()
                - count($visitsRepository->fetchAllVisitsByRoom($room->getId()));
            Console::info("id={$room->getId()} name={$room->getName()} price={$room->getPrice()} players=$visitsLeft/{$room->getmaxPlayers()} open_hour={$room->getOpenHour()} close_hour={$room->getCloseHour()}");
            $count++;
        }
        if (!$count) {
            Console::info('No rooms found :(');
        }
    }

}