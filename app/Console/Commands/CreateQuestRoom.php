<?php

namespace App\Console\Commands;

use App\Exceptions\ValidationException;
use App\Repository\GiftCertificatesRepository\GiftCertificatesRepository;
use App\Repository\QuestRoomsRepository\QuestRoomsRepository;
use App\Service\ValidatorService\ValidatorService;
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
        $validatorService = new ValidatorService();
        if (count($args) != count($this->argsNames))
        {
            Console::error('Invalid arguments count');
            return;
        }
        try {
            $openHour = $validatorService->toInt($this->argsNames[1], $args[1]);
            $closeHour = $validatorService->toInt($this->argsNames[2], $args[2]);
            $price = $validatorService->toFloat($this->argsNames[3], $args[3]);
            $maxPlayers = $validatorService->toInt($this->argsNames[4], $args[4]);
        } catch (ValidationException $exception) {
            Console::error($exception->getMessage());
            return;
        }

        (new QuestRoomsRepository())->create(
            $args[0],
            $openHour,
            $closeHour,
            $price,
            $maxPlayers
        );
        Console::done('Quest room has been created!');
    }

}