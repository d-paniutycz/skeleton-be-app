<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Sys\Application\Messenger\Message\Flag\AfterCurrentMessage;
use Sys\Infrastructure\Messenger\Message\MessengerMessage;

class MessengerPackingService
{
    public function pack(MessengerMessage $message): Envelope
    {
        $stamps = [];
        if ($message instanceof AfterCurrentMessage) {
            $stamps[] = new DispatchAfterCurrentBusStamp();
        }

        return new Envelope($message, $stamps);
    }

    public function unpack(Envelope $envelope): mixed
    {
        return $envelope->last(HandledStamp::class)?->getResult();
    }
}
