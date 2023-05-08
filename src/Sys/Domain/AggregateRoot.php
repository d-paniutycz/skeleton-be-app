<?php

declare(strict_types=1);

namespace Sys\Domain;

use Doctrine\ORM\Mapping as ORM;
use Sys\Application\Messenger\Message\EventMessage;
use Sys\Domain\Entity\Trait\Timestamp\EntityCreatedAtTrait;
use Sys\Domain\Entity\Trait\Timestamp\EntityUpdatedAtTrait;

#[ORM\MappedSuperclass]
abstract class AggregateRoot
{
    use EntityCreatedAtTrait;
    use EntityUpdatedAtTrait;

    /**
     * @var EventMessage[]
     */
    private array $events = [];

    protected function pushEvent(EventMessage $message): void
    {
        $this->events[] = $message;
    }

    /**
     * @return iterable<?EventMessage>
     */
    public function pullEvent(): iterable
    {
        yield array_shift($this->events);
    }
}
