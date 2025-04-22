<?php

use App\Console\Commands\GetActiveGiftCertificates;
use App\Console\Commands\GetQuestRooms;
use Bubblegum\Candyman\Candyman;

use App\Console\Commands\Info;
use App\Console\Commands\Book;
use App\Console\Commands\CreateGiftCertificate;
use App\Console\Commands\CreateUser;
use App\Console\Commands\CreateQuestRoom;

Candyman::registerCommand('info', Info::class);
Candyman::registerCommand('create:gift', CreateGiftCertificate::class);
Candyman::registerCommand('create:user', CreateUser::class);
Candyman::registerCommand('book', Book::class);
Candyman::registerCommand('create:room', CreateQuestRoom::class);
Candyman::registerCommand('get:gifts', GetActiveGiftCertificates::class);
Candyman::registerCommand('get:rooms', GetQuestRooms::class);