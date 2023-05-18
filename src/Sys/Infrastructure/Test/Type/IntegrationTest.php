<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Test\Type;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Sys\Infrastructure\Test\Helper\Trait\DoctrineTransactionHelperTrait;
use Sys\Infrastructure\Test\Helper\Trait\KernelContainerHelperTrait;

abstract class IntegrationTest extends KernelTestCase
{
    use DoctrineTransactionHelperTrait;
    use KernelContainerHelperTrait;

    protected EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::bootKernel();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = parent::getContainer()->get(EntityManagerInterface::class);
        $this->entityManager = $entityManager;

        self::beginTransaction($this->entityManager);
    }

    protected function tearDown(): void
    {
        self::rollbackTransaction($this->entityManager);

        parent::ensureKernelShutdown();
    }
}
