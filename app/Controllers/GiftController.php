<?php

namespace App\Controllers;

use App\Repository\GiftCertificatesRepository\GiftCertificatesRepository;
use Bubblegum\Controller;
use Bubblegum\Request;

class GiftController extends Controller
{
    public function index(): array|string
    {
        $gifts = (new GiftCertificatesRepository())->getActive()->fetchAll();
        return array_map(fn($gift) => $gift['code'], $gifts);
    }

    public function store(Request $request): array|string
    {
        $data = $request->rawData();
        if (array_key_exists('code', $data))
        {
            (new GiftCertificatesRepository())->create((string)$data['code']);
            return [
                'success' => true
            ];
        }
        http_response_code(400);
        return [
            'success' => false,
            'error' => 'No code provided'
        ];
    }
}