<?php

declare(strict_types=1);

namespace App\Client\Port\Web\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(path: '/api/v1/client/auth')]
class ClientAuthController
{
    #[Route(path: 'username', methods: Request::METHOD_POST)]
    public function byUsername(): JsonResponse
    {
        return new JsonResponse();
    }
}
