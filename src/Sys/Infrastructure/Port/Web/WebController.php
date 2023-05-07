<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Port\Web;

use Doctrine\ORM\EntityManagerInterface;
use Sys\Application\Messenger\Bus\CommandBus;
use Sys\Application\Messenger\Bus\QueryBus;

abstract class WebController
{
    public function __construct(
        protected readonly CommandBus $commandBus,
        protected readonly QueryBus $queryBus,
        public EntityManagerInterface $entityManager,
    ) {
    }
}
