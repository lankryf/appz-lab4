<?php

namespace App\Console\Commands;

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
        /** @var User $user */
        $user = (new User())->where('login', '=', $args[0])->first();
        if ($user->getId() === null) {
            Console::error('user not found');
            return;
        }
        /** @var QuestRoom $room */
        $room = QuestRoom::find((int)$args[1]);
        if ($room->getId() === null) {
            Console::error('room not found');
            return;
        }
        $visits = (new Visits())
            ->where('quest_room_id', '=', $room->getId())
            ->where('user_id', '=', $user->getId())
            ->fetchAll();
        if ($visits && count($visits) > $room->getMaxPlayers()) {
            Console::error('no free places');
            return;
        }

        $giftCardUsed = false;

        if (!in_array($args[5], ['no', ''])) {
            $gift = (new GiftCertificate())->where('code', '=', $args[5])->first();
            if ($gift->getId() === null) {
                Console::error('gift certificate not found');
                return;
            }
            if ($gift->getUsed()) {
                Console::error('gift certificate is already used');
                return;
            }
            $giftCardUsed = true;
            $gift->setUsed(true);
            $gift->save();
        }
        if (!$giftCardUsed && (int)$args[4] < $room->getPrice()) {
            Console::error('you have not enough money');
            return;
        }
        Visits::create([
            'quest_room_id' => $room->getId(),
            'user_id' => $user->getId(),
        ]);
        Console::done('booking is done, have fun!');
    }

}