<?php

namespace App\Service\BookingService;

use App\Exceptions\BookingException;

interface BookingServiceInterface
{
    /**
     * @throws BookingException
     */
    public function bookAndReturnChange(
        string $login,
        int $roomId,
        int $fromHour,
        int $toHour,
        float $money,
        string|null $giftCertificateCode = null
    ): float;
}