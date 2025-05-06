<?php

use App\Service\BookingService\BookingService;
use App\Repository\UserRepository\UsersRepository;
use App\Repository\QuestRoomsRepository\QuestRoomsRepository;
use App\Repository\GiftCertificatesRepository\GiftCertificatesRepository;
use App\Repository\VisitsRepository\VisitsRepository;
use Database\Models\User;
use Database\Models\QuestRoom;;
use Database\Models\GiftCertificate;
use App\Exceptions\BookingException;
use PHPUnit\Framework\TestCase;

class BookingServiceTest extends TestCase
{
    private UsersRepository $usersRepository;
    private QuestRoomsRepository $questRoomsRepository;
    private GiftCertificatesRepository $giftCertificatesRepository;
    private VisitsRepository $visitsRepository;
    private BookingService $bookingService;

    protected function setUp(): void
    {
        $this->usersRepository = $this->createMock(UsersRepository::class);
        $this->questRoomsRepository = $this->createMock(QuestRoomsRepository::class);
        $this->giftCertificatesRepository = $this->createMock(GiftCertificatesRepository::class);
        $this->visitsRepository = $this->createMock(VisitsRepository::class);

        $this->bookingService = new BookingService(
            $this->usersRepository,
            $this->questRoomsRepository,
            $this->giftCertificatesRepository,
            $this->visitsRepository
        );
    }

    public function testSuccessfulBookingWithoutGiftCertificate(): void
    {
        $user = $this->createConfiguredMock(User::class, ['getId' => 1]);
        $room = $this->createConfiguredMock(QuestRoom::class, [
            'getId' => 1,
            'getOpenHour' => 8,
            'getCloseHour' => 22,
            'getPrice' => 100,
            'getMaxPlayers' => 10,
        ]);
        $visits = [];

        $this->usersRepository
            ->method('getFirstByLogin')
            ->with('john')
            ->willReturn($user);

        $this->questRoomsRepository
            ->method('getById')
            ->with(1)
            ->willReturn($room);

        $this->visitsRepository
            ->method('fetchAllVisitsByRoom')
            ->with(1)
            ->willReturn($visits);

        $this->visitsRepository
            ->expects($this->once())
            ->method('create')
            ->with(1, 1);

        $change = $this->bookingService->bookAndReturnChange('john', 1, 10, 12, 150.0);

        $this->assertEquals(50, $change);
    }

    public function testBookingWithUsedGiftCertificateThrowsException(): void
    {
        $this->expectException(BookingException::class);
        $this->expectExceptionMessage('gift certificate is already used');

        $user = $this->createConfiguredMock(User::class, ['getId' => 1]);
        $room = $this->createConfiguredMock(QuestRoom::class, [
            'getId' => 1,
            'getOpenHour' => 8,
            'getCloseHour' => 22,
            'getPrice' => 100,
            'getMaxPlayers' => 10,
        ]);
        $gift = $this->createConfiguredMock(GiftCertificate::class, [
            'getId' => 1,
            'getUsed' => true
        ]);
        $visits = [];

        $this->usersRepository->method('getFirstByLogin')->willReturn($user);
        $this->questRoomsRepository->method('getById')->willReturn($room);
        $this->visitsRepository->method('fetchAllVisitsByRoom')->willReturn($visits);
        $this->giftCertificatesRepository->method('getFirstByCode')->willReturn($gift);

        $this->bookingService->bookAndReturnChange('john', 1, 10, 12, 150, 'GIFT123');
    }
}
