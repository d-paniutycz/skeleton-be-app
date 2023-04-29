<?php

declare(strict_types=1);

namespace App\Client\Application\Handler\Command;

use App\Client\Domain\Client;
use App\Client\Domain\Repository\ClientWriteRepository;
use App\Client\Port\Api\Message\Command\ClientCreateCommand;
use Sys\Cqrs\Application\Handler\CommandHandler;

readonly class ClientCreateCommandHandler implements CommandHandler
{
    public function __construct(
        private ClientWriteRepository $clientRepository,
    ) {
    }

    public function __invoke(ClientCreateCommand $message): void
    {
        $client = new Client($message->clientId, $message->clientName);

        $this->clientRepository->persist($client);
    }
}
