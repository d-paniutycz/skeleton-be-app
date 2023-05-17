<?php

namespace Sys\Test\Infrastructure\Messenger;

use InvalidArgumentException;
use stdClass;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Messenger\Stamp\TransportNamesStamp;
use Sys\Application\Messenger\Message\Flag\AsyncMessage;
use Sys\Infrastructure\Messenger\Message\MessengerMessage;
use Sys\Infrastructure\Messenger\MessengerPackingService;
use Sys\Infrastructure\Test\Type\UnitTest;

class MessengerPackingServiceUnitTest extends UnitTest
{
    private readonly MessengerPackingService $subject;

    protected function setUp(): void
    {
        $this->subject = new MessengerPackingService();
    }

    public function testAsyncMessagesStampedForDispatchAfterCurrentBus(): void
    {
        // arrange
        $message = new class implements MessengerMessage, AsyncMessage {};

        // act
        $result = $this->subject->pack($message);

        // assert
        self::assertInstanceOf(Envelope::class, $result);
        self::assertArrayHasKey(DispatchAfterCurrentBusStamp::class, $result->all());
    }

    public function testSyncMessagesHaveSyncTransportStamp(): void
    {
        // arrange
        $message = new class implements MessengerMessage {};

        // act
        $result = $this->subject->pack($message);

        // assert
        self::assertInstanceOf(Envelope::class, $result);
        self::assertArrayHasKey(TransportNamesStamp::class, $result->all());
    }

    public function testUnpackingExceptions(): void
    {
        // arrange
        $envelope = new Envelope(
            new stdClass()
        );

        $message = 'test';

        $stack = new HandlerFailedException(
            $envelope, [new InvalidArgumentException($message)]
        );
        $stack = new HandlerFailedException(
            $envelope, [$stack]
        );

        // act
        $result = $this->subject->unpackException($stack);

        // assert
        self::assertInstanceOf(InvalidArgumentException::class, $result);
        self::assertSame($message, $result->getMessage());
    }

    public function testUnpackingLastResult(): void
    {
        // arrange
        $stamps = [
            new HandledStamp('first', 'first'),
            new HandledStamp('last', 'last'),
        ];

        $envelope = new Envelope(new stdClass(), $stamps);

        // act
        $result = $this->subject->unpack($envelope);

        // assert
        self::assertSame('last', $result);
    }
}
