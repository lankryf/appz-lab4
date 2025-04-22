<?php

namespace App\Console\Commands;

use Bubblegum\Candyman\Command;
use Bubblegum\Candyman\Console;
use Bubblegum\Database\DB;
use Database\Models\GiftCertificate;

class GetActiveGiftCertificates extends Command
{
    protected string $info = 'creating gift certificate';

    public function handle($args): void
    {
        DB::initPDO();
        $gifts = (new GiftCertificate)->where('used', '=', 'false')->get();
        foreach ($gifts as $gift) {
            Console::info("id={$gift->getId()} code={$gift->getCode()}");
        }
    }

}