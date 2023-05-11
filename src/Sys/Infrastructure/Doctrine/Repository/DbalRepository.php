<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Doctrine\Repository;

use Doctrine\DBAL\Connection;
use Sys\Infrastructure\Component\Serializer\ValuablePropertySerializer;

abstract class DbalRepository
{
    public function __construct(
        protected readonly Connection $connection,
        protected readonly ValuablePropertySerializer $serializer,
    ) {
    }
}
