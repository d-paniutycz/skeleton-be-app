<?php

declare(strict_types=1);

namespace App\Client\Application\Handler\Command;

use App\Client\Domain\Client;
use App\Client\Domain\Repository\ClientWriteRepository;
use App\Client\Port\Api\Message\Command\ClientCreateCommand;
use Sys\Application\Messenger\Handler\CommandHandler;

readonly class ClientCreateCommandHandler implements CommandHandler
{
    public function __construct(
        private ClientWriteRepository $clientRepository,
    ) {
    }

    public function __invoke(ClientCreateCommand $message): void
    {
        $client = new Client($message->id, $message->email, $message->password);

        $this->clientRepository->persist($client);
    }
}
