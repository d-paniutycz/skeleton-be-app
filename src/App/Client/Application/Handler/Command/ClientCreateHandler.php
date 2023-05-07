<?php

declare(strict_types=1);

namespace App\Client\Application\Handler\Command;

use App\Client\Application\Repository\ClientReadRepository;
use App\Client\Domain\Client;
use App\Client\Domain\Repository\ClientWriteRepository;
use App\Client\Port\Api\Message\Command\ClientCreateMessage;
use Sys\Application\Exception\Entity\EntityExistsException;
use Sys\Application\Messenger\Handler\CommandHandler;

readonly class ClientCreateHandler implements CommandHandler
{
    public function __construct(
        private ClientWriteRepository $clientWriteRepository,
        private ClientReadRepository $clientReadRepository,
    ) {
    }

    public function __invoke(ClientCreateMessage $message): void
    {
        if ($this->clientReadRepository->findByUsername($message->clientUsername)) {
            throw new EntityExistsException(Client::class, $message->clientUsername, 'username');
        }

        $client = new Client(
            $message->clientId,
            $message->clientUsername,
            $message->clientPassword,
        );

        $this->clientWriteRepository->persist($client);
    }
}
