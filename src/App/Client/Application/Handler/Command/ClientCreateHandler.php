<?php

declare(strict_types=1);

namespace App\Client\Application\Handler\Command;

use App\Client\Domain\Client;
use App\Client\Domain\Repository\ClientWriteRepository;
use App\Client\Port\Api\Message\Command\ClientCreateMessage;
use Sys\Application\Exception\Entity\EntityExistsException;
use Sys\Application\Messenger\Handler\CommandHandler;

readonly class ClientCreateHandler implements CommandHandler
{
    public function __construct(
        private ClientWriteRepository $clientWriteRepository,
    ) {
    }

    public function __invoke(ClientCreateMessage $message): void
    {
        $criteria = [
            'username' => $message->clientUsername,
        ];

        if ($this->clientWriteRepository->findBy($criteria)) {
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
