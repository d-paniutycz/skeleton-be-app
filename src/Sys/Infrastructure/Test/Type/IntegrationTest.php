<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Test\Type;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Sys\Infrastructure\Kernel;
use Sys\Infrastructure\Test\Helper\Trait\DoctrineTransactionHelperTrait;

abstract class IntegrationTest extends KernelTestCase
{
    use DoctrineTransactionHelperTrait;

    protected EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        parent::bootKernel();

        $this->setUpProperties();
        $this->beginTransaction();
    }

    /**
     * @psalm-suppress MixedAssignment
     */
    private function setUpProperties(): void
    {
        $this->entityManager = $this->getService(EntityManagerInterface::class);
    }

    protected function tearDown(): void
    {
        $this->rollbackTransaction();

        parent::tearDown();
    }

    public function getService(string $id): object
    {
        return parent::getContainer()->get($id);
    }

    public function setService(string $id, object $service): void
    {
        parent::getContainer()->set($id, $service);
    }

    final protected static function getKernelClass(): string
    {
        return Kernel::class;
    }
}
