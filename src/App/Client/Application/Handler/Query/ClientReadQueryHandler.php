<?php

declare(strict_types=1);

namespace App\Client\Application\Handler\Query;

use App\Client\Application\Repository\ClientReadRepository;
use App\Client\Port\Api\Message\Query\ClientReadQuery;
use RuntimeException;
use Sys\Cqrs\Application\Handler\QueryHandler;

readonly class ClientReadQueryHandler implements QueryHandler
{
    public function __construct(
        private ClientReadRepository $clientRepository,
    ) {
    }

    public function __invoke(ClientReadQuery $message): mixed
    {
        return $this->clientRepository->find($message->clientId)
            ?? throw new RuntimeException(
                'Client not found:' . $message->clientId->getValue()
            );
    }
}