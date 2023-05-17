<?php

namespace Sys\Test\Domain;

use Sys\Application\Messenger\Message\EventMessage;
use Sys\Domain\AggregateRoot;
use Sys\Infrastructure\Test\Type\UnitTest;

class AggregateRootUnitTest extends UnitTest
{
    public function testAggregatedEventPulling(): void
    {
        // arrange
        $eventA = self::createStub(EventMessage::class);
        $eventB = self::createStub(EventMessage::class);

        $subject = new class($eventA, $eventB) extends AggregateRoot {
            public function __construct(EventMessage $eventA, EventMessage $eventB)
            {
                $this->pushEvent($eventA);
                $this->pushEvent($eventB);
            }
        };

        // act
        $events = iterator_to_array(
            $subject->pullEvents()
        );

        // assert
        self::assertCount(2, $events);
        self::assertSame($eventA, $events[0]);
        self::assertSame($eventB, $events[1]);
        self::assertEmpty(
            iterator_to_array(
                $subject->pullEvents()
            )
        );
    }
}
