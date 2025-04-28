<?php

namespace App\Console\Commands;

use App\Repository\GiftCertificatesRepository\GiftCertificatesRepository;
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
        $gifts = (new GiftCertificatesRepository())->getActive();
        $count = 0;
        foreach ($gifts as $gift) {
            Console::info("id={$gift->getId()} code={$gift->getCode()}");
            $count++;
        }
        if (!$count) {
            Console::info('No certificates found :(');
        }
    }

}