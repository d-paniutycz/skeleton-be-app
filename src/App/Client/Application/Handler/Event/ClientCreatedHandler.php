<?php

declare(strict_types=1);

namespace App\Client\Application\Handler\Event;

use App\Client\Application\Dto\ClientDto;
use App\Client\Domain\Client;
use App\Client\Port\Api\Message\Event\ClientCreatedMessage;
use App\Client\Port\Api\Message\Query\ClientReadMessage;
use Sys\Application\Exception\Entity\EntityNotFoundException;
use Sys\Application\Messenger\Bus\QueryBus;
use Sys\Application\Messenger\Handler\EventHandler;

class ClientCreatedHandler implements EventHandler
{
    public function __construct(
        private readonly QueryBus $queryBus,
    ) {
    }

    public function __invoke(ClientCreatedMessage $message): void
    {
        /** @var ?ClientDto $clientDto */
        $clientDto = $this->queryBus->dispatch(new ClientReadMessage($message->clientId));

        if (is_null($clientDto)) {
            throw new EntityNotFoundException(Client::class, $message->clientId);
        }
    }
}
