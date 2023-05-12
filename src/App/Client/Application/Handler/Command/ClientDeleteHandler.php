<?php

declare(strict_types=1);

namespace App\Client\Application\Handler\Command;

use App\Client\Domain\Client;
use App\Client\Domain\Repository\ClientWriteRepository;
use App\Client\Port\Api\Message\Command\ClientDeleteMessage;
use Sys\Application\Exception\Entity\EntityNotFoundException;
use Sys\Application\Exception\Input\InputStringValueException;
use Sys\Application\Messenger\Handler\CommandHandler;

readonly class ClientDeleteHandler implements CommandHandler
{
    public function __construct(
        private ClientWriteRepository $clientWriteRepository,
    ) {
    }

    public function __invoke(ClientDeleteMessage $message): void
    {
        $client = $this->clientWriteRepository->find($message->clientId) ??
            throw new EntityNotFoundException(Client::class, $message->clientId);

        $this->clientWriteRepository->delete($client);
    }
}
