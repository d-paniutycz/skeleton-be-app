<?php

declare(strict_types=1);

namespace App\Client\Application\Handler\Query;

use App\Client\Application\Dto\ClientDto;
use App\Client\Application\Repository\ClientReadRepository;
use App\Client\Domain\Client;
use App\Client\Port\Api\Message\Query\ClientReadMessage;
use Sys\Application\Exception\Entity\EntityNotFoundException;
use Sys\Application\Messenger\Handler\QueryHandler;

readonly class ClientReadHandler implements QueryHandler
{
    public function __construct(
        private ClientReadRepository $clientReadRepository,
    ) {
    }

    public function __invoke(ClientReadMessage $message): ?ClientDto
    {
        return $this->clientReadRepository->find($message->clientId)
            ?? throw new EntityNotFoundException(Client::class, $message->clientId);
    }
}
