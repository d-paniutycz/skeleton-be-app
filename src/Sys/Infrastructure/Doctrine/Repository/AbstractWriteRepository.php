<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Sys\Application\Messenger\Bus\EventBus;
use Sys\Domain\AggregateRoot;

abstract class AbstractWriteRepository
{
    public function __construct(
        protected readonly EntityManagerInterface $manager,
        protected readonly EventBus $eventBus,
    ) {
    }

    public function save(object $entity): void
    {
        $this->manager->persist($entity);
        $this->manager->flush();

        if ($entity instanceof AggregateRoot) {
            $this->eventBus->dispatchFromRoot($entity);
        }
    }

    public function delete(object $entity): void
    {
        $this->manager->remove($entity);
        $this->manager->flush();

        if ($entity instanceof AggregateRoot) {
            $this->eventBus->dispatchFromRoot($entity);
        }
    }
}
