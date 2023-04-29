<?php

declare(strict_types=1);

namespace Sys\Cqrs\Infrastructure\Messenger\Bus;

use Symfony\Component\Messenger\MessageBusInterface;
use Sys\Cqrs\Application\Bus\EventBus;
use Sys\Cqrs\Application\Message\EventMessage;

readonly class MessengerEventBus implements EventBus
{
    public function __construct(
        private MessageBusInterface $event,
    ) {
    }

    public function dispatch(EventMessage $message): void
    {
        $this->event->dispatch($message);
    }
}
