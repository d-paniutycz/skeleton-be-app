<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Messenger\Bus;

use Symfony\Component\Messenger\MessageBusInterface;
use Sys\Application\Messenger\Bus\CommandBus;
use Sys\Application\Messenger\Message\CommandMessage;
use Sys\Infrastructure\Messenger\MessengerPackingService;

readonly class MessengerCommandBus implements CommandBus
{
    public function __construct(
        private MessageBusInterface $commandBus,
        private MessengerPackingService $packingService,
    ) {
    }

    public function dispatch(CommandMessage $message): void
    {
        $this->commandBus->dispatch(
            $this->packingService->pack($message)
        );
    }
}
