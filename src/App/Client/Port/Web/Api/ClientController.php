<?php

declare(strict_types=1);

namespace App\Client\Port\Web\Api;

use App\Client\Application\Input\ClientCreateInput;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sys\Infrastructure\Port\Web\AbstractWebController;

#[Route(path: '/api/v1/client')]
final class ClientController extends AbstractWebController
{
    #[Route(path: null, methods: Request::METHOD_POST)]
    public function create(ClientCreateInput $createInput): JsonResponse
    {
        return new JsonResponse($createInput);
    }
}
