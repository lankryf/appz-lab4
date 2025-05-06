<?php

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Repository\GiftCertificatesRepository\GiftCertificatesRepository;
use App\Repository\QuestRoomsRepository\QuestRoomsRepository;
use App\Service\ValidatorService\ValidatorService;
use Bubblegum\Candyman\Console;
use Bubblegum\Controller;
use Bubblegum\Request;

class QuestRoomController extends Controller
{
    public function index(Request $request): array|string
    {
        $data = $request->all();
        $validatorService = new ValidatorService();
        $openHour = 0;
        $closeHour = 24;
        try {
            if (key_exists('openHour', $data)) {
                $openHour = $validatorService->toInt('open hour', $data['openHour']);
            }
            if (key_exists('closeHour', $data)) {
                $closeHour = $validatorService->toInt('close hour', $data['closeHour']);
            }
        } catch (ValidationException $exception) {
            return [
                'success' => false,
                'error' => $exception->getMessage(),
            ];
        }
        $rooms = (new QuestRoomsRepository())->getByTime($openHour, $closeHour)->fetchAll();
        return array_map(
            static function($room)
            {
                return [
                    'id' => $room['id'],
                    'name' => $room['name'],
                    'price' => $room['price'],
                    'openHour' => $room['open_hour'],
                    'closeHour' => $room['close_hour'],
                ];
            },
            $rooms
        );
    }

    public function store(Request $request): array|string
    {
        $data = $request->rawData();
        $dataNames = ['name', 'openHour', 'closeHour', 'price', 'maxPlayers'];
        foreach ($dataNames as $name) {
            if (!array_key_exists($name, $data)) {
                http_response_code(400);
                return ['success' => false, 'error' => 'Missing ' . $name . ' parameter'];
            }
        }
        $validatorService = new ValidatorService();
        try {
            $openHour = $validatorService->toInt('openHour', $data['openHour']);
            $closeHour = $validatorService->toInt('closeHour', $data['closeHour']);
            $price = $validatorService->toFloat('price', $data['price']);
            $maxPlayers = $validatorService->toInt('maxPlayers', $data['maxPlayers']);
        } catch (ValidationException $exception) {
            http_response_code(400);
            return ['success' => false, 'error' => 'Parameter type error'];
        }

        (new QuestRoomsRepository())->create(
            (string)$data['name'],
            $openHour,
            $closeHour,
            $price,
            $maxPlayers
        );
        return ['success' => true];
    }
}