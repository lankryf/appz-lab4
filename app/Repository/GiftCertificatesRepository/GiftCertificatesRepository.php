<?php

namespace App\Repository\GiftCertificatesRepository;

use Bubblegum\Database\Model;
use Database\Models\GiftCertificate;

class GiftCertificatesRepository implements GiftCertificatesRepositoryInterface
{

    public function create(string $code): GiftCertificate|Model
    {
        return GiftCertificate::create([
            'code' => $code,
            'used' => 'false',
        ]);
    }

    public function getActive(): GiftCertificate|Model
    {
        return (new GiftCertificate)->where('used', '=', 'false')->get();
    }

    public function getFirstByCode(string $code): GiftCertificate|Model
    {
        return (new GiftCertificate)->where('code', '=', $code)->first();
    }

    public function save(GiftCertificate $certificate): void
    {
        $certificate->save();
    }
}