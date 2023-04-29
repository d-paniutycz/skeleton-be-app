<?php

declare(strict_types=1);

namespace Sys\Cqrs\Infrastructure\Messenger\Bus;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Sys\Cqrs\Application\Bus\QueryBus;
use Sys\Cqrs\Application\Message\QueryMessage;

readonly class MessengerQueryBus implements QueryBus
{
    public function __construct(
        private MessageBusInterface $query,
    ) {
    }

    public function dispatch(QueryMessage $message): mixed
    {
        $envelope = $this->query->dispatch($message);

        return $envelope->last(HandledStamp::class)?->getResult();
    }
}
