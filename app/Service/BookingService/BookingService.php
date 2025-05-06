<?php

namespace App\Service\BookingService;

use App\Exceptions\BookingException;
use App\Repository\GiftCertificatesRepository\GiftCertificatesRepository;
use App\Repository\QuestRoomsRepository\QuestRoomsRepository;
use App\Repository\UserRepository\UsersRepository;
use App\Repository\VisitsRepository\VisitsRepository;


class BookingService implements BookingServiceInterface
{

    public function __construct(
        private UsersRepository $usersRepository,
        private QuestRoomsRepository $questRoomsRepository,
        private GiftCertificatesRepository $giftCertificatesRepository,
        private VisitsRepository $visitsRepository
    ) {}

    public static function get()
    {
        return new static(
            new UsersRepository(),
            new QuestRoomsRepository(),
            new GiftCertificatesRepository(),
            new VisitsRepository()
        );
    }

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
        $user = $this->usersRepository->getFirstByLogin($login);
        if ($user->getId() === null) {
            throw new BookingException('user not found');
        }
        $room = $this->questRoomsRepository->getById($roomId);
        if ($room->getId() === null) {
            throw new BookingException('room not found');
        }
        if ($room->getOpenHour() > $fromHour || $room->getCloseHour() < $toHour)
        {
            throw new BookingException('booking time is not fit');
        }

        $visits = $this->visitsRepository->fetchAllVisitsByRoom($roomId);
        if ($visits && count($visits) > $room->getMaxPlayers()) {
            throw new BookingException('no free places');
        }

        $giftCardUsed = false;
        $change = $money - $room->getPrice();
        if (!is_null($giftCertificateCode)) {
            $gift = $this->giftCertificatesRepository->getFirstByCode($giftCertificateCode);
            if ($gift->getId() === null) {
                throw new BookingException('gift certificate not found');
            }
            if ($gift->getUsed()) {
                throw new BookingException('gift certificate is already used');
            }
            $giftCardUsed = true;
            $gift->setUsed(true);
            $this->giftCertificatesRepository->save($gift);
            $change = $money;
        }
        if (!$giftCardUsed && $money < $room->getPrice()) {
            throw new BookingException('you have not enough money');
        }

        $this->visitsRepository->create($room->getId(), $user->getId());

        return $change;
    }
}