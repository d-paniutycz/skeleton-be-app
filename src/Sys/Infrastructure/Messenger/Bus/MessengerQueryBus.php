<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Messenger\Bus;

use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Sys\Application\Messenger\Bus\QueryBus;
use Sys\Application\Messenger\Message\QueryMessage;

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
