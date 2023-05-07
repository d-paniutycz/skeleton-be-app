<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Doctrine\Repository;

use Doctrine\ORM\EntityManagerInterface;

abstract class OrmRepository
{
    public function __construct(
        protected readonly EntityManagerInterface $manager,
    ) {
    }
}
