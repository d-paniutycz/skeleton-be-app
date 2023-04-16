<?php

namespace Sys\Infrastructure\Test\Helper\Trait;

use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;

trait DoctrineTransactionHelperTrait
{
    private static function beginTransaction(EntityManagerInterface $manager): void
    {
        $connection = $manager->getConnection();
        if ($connection->isTransactionActive()) {
            throw new RuntimeException('Transaction is active, but should be not.');
        }

        $connection->beginTransaction();
    }

    private static function rollbackTransaction(EntityManagerInterface $manager): void
    {
        $connection = $manager->getConnection();
        if ($connection->isTransactionActive()) {
            $connection->rollBack();
        }
    }
}
