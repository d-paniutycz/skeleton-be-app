<?php

declare(strict_types=1);

namespace App\Client\Port\Web\Rest;

use App\Client\Application\Dto\ClientDto;
use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientName;
use App\Client\Port\Api\Message\Command\ClientCreateCommand;
use App\Client\Port\Api\Message\Query\ClientReadQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Sys\Cqrs\Application\Bus\CommandBus;
use Sys\Cqrs\Application\Bus\QueryBus;

#[AsController]
readonly class ClientController
{
    public function __construct(
        private CommandBus $commandBus,
        private QueryBus $queryBus,
    ) {
    }

    #[Route(path: '/client', methods: [Request::METHOD_POST])]
    public function create(): JsonResponse
    {
        $clientId = ClientId::generate();

        $this->commandBus->dispatch(
            new ClientCreateCommand(
                $clientId,
                new ClientName('some name'),
            )
        );

        /** @var ClientDto $dto */
        $dto = $this->queryBus->dispatch(
            new ClientReadQuery($clientId)
        );

        return new JsonResponse($dto);
    }

    #[Route(path: '/client', methods: [Request::METHOD_GET])]
    public function read(): JsonResponse
    {
        /** @var ClientDto $dto */
        $dto = $this->queryBus->dispatch(
            new ClientReadQuery(
                new ClientId('test_id'),
            )
        );

        return new JsonResponse($dto);
    }
}
