<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Messenger\Bus;

use Symfony\Component\Messenger\MessageBusInterface;
use Sys\Application\Messenger\Bus\EventBus;
use Sys\Application\Messenger\Message\EventMessage;
use Sys\Domain\AggregateRoot;
use Sys\Infrastructure\Messenger\MessengerPackingService;

readonly class MessengerEventBus implements EventBus
{
    public function __construct(
        private MessageBusInterface $eventBus,
        private MessengerPackingService $packingService,
    ) {
    }

    public function dispatch(EventMessage $message): void
    {
        $this->eventBus->dispatch(
            $this->packingService->pack($message)
        );
    }

    public function dispatchFromRoot(AggregateRoot $root): void
    {
        foreach ($root->pullEvents() as $event) {
            $this->eventBus->dispatch($event);
        }
    }
}
