<?php

namespace App\Console\Commands;

use App\Exceptions\BookingException;
use App\Exceptions\ValidationException;
use App\Service\BookingService\BookingService;
use App\Service\ValidatorService\ValidatorService;
use Bubblegum\Candyman\Command;
use Bubblegum\Candyman\Console;
use Bubblegum\Database\DB;
use Database\Models\GiftCertificate;
use Database\Models\QuestRoom;
use Database\Models\User;
use Database\Models\Visits;

class Book extends Command
{
    protected string $info = 'booking quest room';
    protected array $argsNames = ['login', 'room_id', 'from_hour', 'to_hour', 'money', 'gift_code|no'];

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
            $roomId = $validatorService->toInt($this->argsNames[1], $args[1]);
            $fromHour = $validatorService->toInt($this->argsNames[2], $args[2]);
            $toHour = $validatorService->toInt($this->argsNames[3], $args[3]);
            $money = $validatorService->toFloat($this->argsNames[4], $args[4]);

            if (in_array($args[5], ['no', '']))
            {
                $gift = null;
            } else
            {
                $gift = $args[5];
                Console::info("Gift certificate used ($gift)");
            }


            $change = (new BookingService())->bookAndReturnChange(
                $args[0],
                $roomId,
                $fromHour,
                $toHour,
                $money,
                $gift
            );
            Console::done("Room has been booked, your change is $change");
        } catch (BookingException $exception) {
            Console::error('Booking went wrong: ' . $exception->getMessage());
        } catch (ValidationException $exception) {
            Console::error('Wrong type: ' . $exception->getMessage());
        }
    }

}