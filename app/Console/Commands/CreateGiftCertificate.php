<?php

namespace App\Console\Commands;

use App\Exceptions\ValidationException;
use App\Repository\GiftCertificatesRepository\GiftCertificatesRepository;
use App\Service\ValidatorService\ValidatorService;
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
        if (count($args) != count($this->argsNames))
        {
            Console::error('Invalid arguments count');
            return;
        }
        (new GiftCertificatesRepository())->create($args[0]);
        Console::done('Gift certificate has been created!');
    }

}