<?php

declare(strict_types=1);

namespace App\Client\Port\Web\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sys\Infrastructure\Controller\WebController;

#[Route(path: '/api/v1/client/auth')]
class ClientAuthController extends WebController
{
    #[Route(path: '/email', methods: Request::METHOD_POST)]
    public function email(): JsonResponse
    {
        return new JsonResponse('email login');
    }
}
