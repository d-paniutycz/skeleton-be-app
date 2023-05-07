<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Doctrine\Repository;

use Doctrine\DBAL\Connection;

abstract class DbalRepository
{
    public function __construct(
        protected readonly Connection $connection,
    ) {
    }
}
