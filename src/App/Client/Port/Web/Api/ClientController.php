<?php

declare(strict_types=1);

namespace App\Client\Port\Web\Api;

use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientName;
use App\Client\Port\Api\Message\Command\ClientCreateCommand;
use App\Client\Port\Api\Message\Query\ClientReadQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sys\Domain\Value\UniqueStringValue;
use Sys\Infrastructure\Controller\WebController;

#[Route(path: '/api/v1/client', requirements: ['clientId' => UniqueStringValue::PATTERN])]
final class ClientController extends WebController
{
    #[Route(path: null, methods: Request::METHOD_POST)]
    public function create(): JsonResponse
    {
        $this->commandBus->dispatch(
            new ClientCreateCommand(
                $clientId = ClientId::generate(),
                new ClientName('some name'),
            )
        );

        return $this->jsonResponseFromQuery(
            new ClientReadQuery($clientId)
        );
    }

    #[Route(path: '/{clientId}', methods: Request::METHOD_GET)]
    public function read(ClientId $clientId): JsonResponse
    {
        return $this->jsonResponseFromQuery(
            new ClientReadQuery($clientId)
        );
    }
}
