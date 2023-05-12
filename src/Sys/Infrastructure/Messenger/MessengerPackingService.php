<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\TransportNamesStamp;
use Sys\Application\Messenger\Message\Flag\AsyncMessage;
use Sys\Infrastructure\Messenger\Message\MessengerMessage;

class MessengerPackingService
{
    public function pack(MessengerMessage $message): Envelope
    {
        $stamp = $message instanceof AsyncMessage
            ? new DispatchAfterCurrentBusStamp()
            : new TransportNamesStamp(['sync']);

        return new Envelope($message, [$stamp]);
    }

    public function unpack(Envelope $envelope): mixed
    {
        return $envelope->last(HandledStamp::class)?->getResult();
    }
}
