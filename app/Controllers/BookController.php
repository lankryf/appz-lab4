<?php

namespace App\Controllers;

use App\Exceptions\BookingException;
use App\Exceptions\ValidationException;
use App\Repository\GiftCertificatesRepository\GiftCertificatesRepository;
use App\Service\BookingService\BookingService;
use App\Service\ValidatorService\ValidatorService;
use Bubblegum\Candyman\Console;
use Bubblegum\Controller;
use Bubblegum\Request;

class BookController extends Controller
{
    public function store(Request $request): array|string
    {
        $data = $request->rawData();
        $dataNames = ['login', 'roomId', 'fromHour', 'toHour', 'money'];
        foreach ($dataNames as $name) {
            if (!array_key_exists($name, $data)) {
                http_response_code(400);
                return ['success' => false, 'error' => 'Missing ' . $name . ' parameter'];
            }
        }
        $validatorService = new ValidatorService();
        try {
            $roomId = $validatorService->toInt('roomId', $data['roomId']);
            $fromHour = $validatorService->toInt('fromHour', $data['fromHour']);
            $toHour = $validatorService->toInt('toHour', $data['toHour']);
            $money = $validatorService->toFloat('money', $data['money']);

            if (!array_key_exists('giftCardCode', $data))
            {
                $gift = null;
            } else {
                $gift = $data['giftCardCode'];
            }

            $change = BookingService::get()->bookAndReturnChange(
                (string)$data['login'],
                $roomId,
                $fromHour,
                $toHour,
                $money,
                $gift
            );
            return ['success' => true, 'change' => $change];
        } catch (BookingException $exception) {
            http_response_code(400);
            return ['success' => false, 'error' => 'Booking went wrong: ' . $exception->getMessage()];
        } catch (ValidationException $exception) {
            http_response_code(400);
            return ['success' => false, 'error' => 'Wrong type: ' . $exception->getMessage()];
        }
    }
}