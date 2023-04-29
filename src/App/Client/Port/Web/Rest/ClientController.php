<?php

declare(strict_types=1);

namespace App\Client\Port\Web\Rest;

use App\Client\Domain\Client\ClientId;
use App\Client\Domain\Client\ClientName;
use App\Client\Port\Api\Message\Command\ClientCreateCommand;
use App\Client\Port\Api\Message\Query\ClientReadQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sys\Cqrs\Application\Bus\CommandBus;
use Sys\Cqrs\Application\Bus\QueryBus;

#[AsController]
class ClientController
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly QueryBus $queryBus,
    ) {
    }

    private function serialize(mixed $object): array
    {
        $normalizers = [new PropertyNormalizer()];
        $serializer = new Serializer($normalizers, []);

        return $serializer->normalize($object);
    }

    #[Route(path: '/client', methods: [Request::METHOD_POST])]
    public function create(): JsonResponse
    {
        $clientId = new ClientId(
            'test_' . rand(0, 10000)
        );

        $this->commandBus->dispatch(
            new ClientCreateCommand(
                $clientId,
                new ClientName('some name'),
            )
        );

        $result = $this->queryBus->dispatch(
            new ClientReadQuery($clientId)
        );

        return new JsonResponse(
            $this->serialize($result)
        );
    }

    #[Route(path: '/client', methods: [Request::METHOD_GET])]
    public function read(): JsonResponse
    {
        $result = $this->queryBus->dispatch(
            new ClientReadQuery(
                new ClientId('test_id'),
            )
        );

        return new JsonResponse(
            $this->serialize($result)
        );
    }
}
