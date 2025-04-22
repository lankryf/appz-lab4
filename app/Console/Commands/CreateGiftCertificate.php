<?php

namespace App\Console\Commands;

use Bubblegum\Candyman\Command;
use Bubblegum\Candyman\Console;
use Bubblegum\Database\DB;
use Database\Models\GiftCertificate;

class CreateGiftCertificate extends Command
{
    protected string $info = 'creating gift certificate';

    protected array $argsNames = ['code'];

    public function handle($args): void
    {
        DB::initPDO();
        GiftCertificate::create([
            'code' => $args[0],
            'used' => 'false',
        ]);
        Console::info('created');
    }

}