<?php

namespace App\Repository\GiftCertificatesRepository;

use Bubblegum\Database\Model;
use Database\Models\GiftCertificate;

interface GiftCertificatesRepositoryInterface
{
    public function create(string $code): GiftCertificate|Model;

    public function getActive(): GiftCertificate|Model;

    public function getFirstByCode(string $code): GiftCertificate|Model;

    public function save(GiftCertificate $certificate): void;
}