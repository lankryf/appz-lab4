<?php

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Repository\GiftCertificatesRepository\GiftCertificatesRepository;
use App\Repository\QuestRoomsRepository\QuestRoomsRepository;
use App\Repository\UserRepository\UsersRepository;
use App\Service\ValidatorService\ValidatorService;
use Bubblegum\Candyman\Console;
use Bubblegum\Controller;
use Bubblegum\Request;

class RegisterController extends Controller
{
    public function store(Request $request): array|string
    {
        $data = $request->rawData();
        $dataNames = ['login'];
        foreach ($dataNames as $name) {
            http_response_code(400);
            if (!array_key_exists($name, $data)) {
                return ['success' => false, 'error' => 'Missing ' . $name . ' parameter'];
            }
        }

        $user = (new UsersRepository())->getFirstByLogin((string)$data['login']);
        if (is_null($user->getId()))
        {
            (new UsersRepository())->create((string)$data['login']);
            return ['success' => true];
        }
        http_response_code(400);
        return ['success' => false, 'error' => 'User already exists'];

    }
}