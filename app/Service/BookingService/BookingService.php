<?php

namespace App\Service\BookingService;

use App\Exceptions\BookingException;
use App\Repository\GiftCertificatesRepository\GiftCertificatesRepository;
use App\Repository\QuestRoomsRepository\QuestRoomsRepository;
use App\Repository\UserRepository\UsersRepository;
use App\Repository\VisitsRepository\VisitsRepository;


class BookingService implements BookingServiceInterface
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
    ): float {
        $usersRepository = new UsersRepository();
        $questRoomsRepository = new QuestRoomsRepository();
        $giftCertificateRepository = new GiftCertificatesRepository();
        $visitsRepository = new VisitsRepository();

        $user = $usersRepository->getFirstByLogin($login);
        if ($user->getId() === null) {
            throw new BookingException('user not found');
        }
        $room = $questRoomsRepository->getById($roomId);
        if ($room->getId() === null) {
            throw new BookingException('room not found');
        }
        if ($room->getOpenHour() > $fromHour || $room->getCloseHour() < $toHour)
        {
            throw new BookingException('booking time is not fit');
        }

        $visits = $visitsRepository->fetchAllVisitsByRoom($roomId);
        if ($visits && count($visits) > $room->getMaxPlayers()) {
            throw new BookingException('no free places');
        }

        $giftCardUsed = false;
        $change = $money - $room->getPrice();
        if (!is_null($giftCertificateCode)) {
            $gift = $giftCertificateRepository->getFirstByCode($giftCertificateCode);
            if ($gift->getId() === null) {
                throw new BookingException('gift certificate not found');
            }
            if ($gift->getUsed()) {
                throw new BookingException('gift certificate is already used');
            }
            $giftCardUsed = true;
            $gift->setUsed(true);
            $giftCertificateRepository->save($gift);
            $change = $money;
        }
        if (!$giftCardUsed && $money < $room->getPrice()) {
            throw new BookingException('you have not enough money');
        }

        $visitsRepository->create($room->getId(), $user->getId());

        return $change;
    }
}