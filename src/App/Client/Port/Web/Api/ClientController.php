<?php

declare(strict_types=1);

namespace App\Client\Port\Web\Api;

use App\Client\Application\Input\ClientCreateInput;
use App\Client\Domain\Value\ClientId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sys\Infrastructure\Port\Web\WebController;

#[Route(path: '/api/v1/client')]
final class ClientController extends WebController
{
    #[Route(path: null, methods: Request::METHOD_POST)]
    public function create(ClientCreateInput $createInput): JsonResponse
    {
        return new JsonResponse($createInput);
    }

    #[Route(path: '/{clientId}', methods: Request::METHOD_GET)]
    public function get(ClientId $clientId): JsonResponse
    {
        return new JsonResponse($clientId);
    }
}
