<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineConnectionManager
{
    public function __construct(
        private readonly Connection $pg1PriConnection,
        private readonly Connection $pg1RepConnection,
    ) {
    }

    public function getConnection(): Connection
    {
        return $this->pg1PriConnection->isTransactionActive()
            ? $this->pg1PriConnection
            : $this->pg1RepConnection;
    }
}
