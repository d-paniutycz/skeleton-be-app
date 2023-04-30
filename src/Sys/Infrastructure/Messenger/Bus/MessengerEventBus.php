<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Messenger\Bus;

use Symfony\Component\Messenger\MessageBusInterface;
use Sys\Application\Messenger\Bus\EventBus;
use Sys\Application\Messenger\Message\EventMessage;

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
