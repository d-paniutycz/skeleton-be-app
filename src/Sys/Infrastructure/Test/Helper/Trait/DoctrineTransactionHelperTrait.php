<?php

namespace Sys\Infrastructure\Test\Helper\Trait;

use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;

trait DoctrineTransactionHelperTrait
{
    protected EntityManagerInterface $entityManager;

    private function beginTransaction(): void
    {
        $connection = $this->entityManager->getConnection();
        if ($connection->isTransactionActive()) {
            throw new RuntimeException('Transaction is active, but should be not.');
        }

        $connection->beginTransaction();
    }

    private function rollbackTransaction(): void
    {
        $connection = $this->entityManager->getConnection();
        if ($connection->isTransactionActive()) {
            $connection->rollBack();
        }
    }
}
