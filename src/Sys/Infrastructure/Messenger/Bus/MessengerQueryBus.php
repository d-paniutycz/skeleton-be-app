<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Messenger\Bus;

use RuntimeException;
use Symfony\Component\Messenger\MessageBusInterface;
use Sys\Application\Messenger\Bus\QueryBus;
use Sys\Application\Messenger\Message\Flag\AsyncMessage;
use Sys\Application\Messenger\Message\QueryMessage;
use Sys\Infrastructure\Messenger\MessengerPackingService;

readonly class MessengerQueryBus implements QueryBus
{
    public function __construct(
        private MessageBusInterface $queryBus,
        private MessengerPackingService $packingService,
    ) {
    }

    public function dispatch(QueryMessage $message): mixed
    {
        if ($message instanceof AsyncMessage) {
            throw new RuntimeException('Query messages cant be dispatched asynchronously.');
        }

        $envelope = $this->queryBus->dispatch(
            $this->packingService->pack($message)
        );

        return $this->packingService->unpack($envelope);
    }
}
