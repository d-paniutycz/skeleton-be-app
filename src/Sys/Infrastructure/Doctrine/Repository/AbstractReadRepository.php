<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Doctrine\Repository;

use Sys\Infrastructure\Component\Serializer\ValuablePropertySerializer;
use Sys\Infrastructure\Doctrine\DoctrineConnectionManager;

abstract class AbstractReadRepository
{
    public function __construct(
        protected readonly DoctrineConnectionManager $manager,
        protected readonly ValuablePropertySerializer $serializer,
    ) {
    }
}
