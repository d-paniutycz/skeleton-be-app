<?php

declare(strict_types=1);

namespace App\Client\Application\Handler\Command;

use App\Client\Domain\Client;
use App\Client\Domain\Repository\ClientWriteRepository;
use App\Client\Port\Api\Message\Command\ClientTokenCreateMessage;
use Sys\Application\Exception\Entity\EntityNotFoundException;
use Sys\Application\Messenger\Handler\CommandHandler;

class ClientTokenCreateHandler implements CommandHandler
{
    public function __construct(
        private readonly ClientWriteRepository $clientWriteRepository,
    ) {
    }

    public function __invoke(ClientTokenCreateMessage $message): void
    {
        $client = $this->clientWriteRepository->find($message->clientId)
            ?? throw new EntityNotFoundException(Client::class, $message->clientId);

        $client->createToken($message->tokenValue, $message->remember);

        $this->clientWriteRepository->save($client);
    }
}
