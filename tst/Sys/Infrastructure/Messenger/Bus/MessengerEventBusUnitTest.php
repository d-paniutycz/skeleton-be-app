<?php

namespace Sys\Test\Infrastructure\Messenger\Bus;

use stdClass;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Sys\Application\Messenger\Message\EventMessage;
use Sys\Domain\AggregateRoot;
use Sys\Infrastructure\Messenger\Bus\MessengerEventBus;
use Sys\Infrastructure\Messenger\MessengerPackingService;
use Sys\Infrastructure\Test\Type\UnitTest;

class MessengerEventBusUnitTest extends UnitTest
{
    private readonly MessengerEventBus $subject;

    private readonly MessageBusInterface $messageBus;

    protected function setUp(): void
    {
        $this->messageBus = self::createMock(MessageBusInterface::class);

        $this->subject = new MessengerEventBus(
            $this->messageBus,
            self::createStub(MessengerPackingService::class),
        );
    }

    public function testDispatchingFromAggregateRoot(): void
    {
        // arrange
        $event = self::createStub(EventMessage::class);

        $root = new class ($event) extends AggregateRoot {
            public function __construct(EventMessage $event)
            {
                $this->pushEvent($event);
                $this->pushEvent($event);
            }
        };

        $envelope = new Envelope(
            new stdClass()
        );

        // assert
        $this->messageBus->expects(self::exactly(2))
            ->method('dispatch')
            ->willReturn($envelope);

        // act
        $this->subject->dispatchFromRoot($root);
    }
}
