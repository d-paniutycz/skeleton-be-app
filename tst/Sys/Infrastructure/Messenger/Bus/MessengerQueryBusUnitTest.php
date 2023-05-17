<?php

namespace Sys\Test\Infrastructure\Messenger\Bus;

use RuntimeException;
use Symfony\Component\Messenger\MessageBusInterface;
use Sys\Application\Messenger\Message\Flag\AsyncMessage;
use Sys\Application\Messenger\Message\QueryMessage;
use Sys\Infrastructure\Messenger\Bus\MessengerQueryBus;
use Sys\Infrastructure\Messenger\MessengerPackingService;
use Sys\Infrastructure\Test\UnitTest;

class MessengerQueryBusUnitTest extends UnitTest
{
    private readonly MessengerQueryBus $subject;

    protected function setUp(): void
    {
        $this->subject = new MessengerQueryBus(
            self::createStub(MessageBusInterface::class),
            self::createStub(MessengerPackingService::class),
        );
    }

    public function testExceptionThrownOnAsyncQueryMessage(): void
    {
        // arrange
        $message = new class implements QueryMessage, AsyncMessage {};

        // assert
        self::expectException(RuntimeException::class);

        // act
        $this->subject->dispatch($message);
    }
}
