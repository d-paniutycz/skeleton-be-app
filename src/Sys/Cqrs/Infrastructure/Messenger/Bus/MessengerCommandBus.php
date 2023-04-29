<?php

declare(strict_types=1);

namespace Sys\Cqrs\Infrastructure\Messenger\Bus;

use Symfony\Component\Messenger\MessageBusInterface;
use Sys\Cqrs\Application\Bus\CommandBus;
use Sys\Cqrs\Application\Message\CommandMessage;

readonly class MessengerCommandBus implements CommandBus
{
    public function __construct(
        private MessageBusInterface $command,
    ) {
    }

    public function dispatch(CommandMessage $message): void
    {
        $this->command->dispatch($message);
    }
}
