<?php

namespace Sys\Test\Infrastructure\Doctrine;

use Doctrine\DBAL\Connection;
use Sys\Infrastructure\Doctrine\DoctrineConnectionManager;
use Sys\Infrastructure\Test\Type\UnitTest;

class DoctrineConnectionManagerUnitTest extends UnitTest
{
    private readonly DoctrineConnectionManager $subject;

    private readonly Connection $primary;

    private readonly Connection $replica;

    protected function setUp(): void
    {
        $this->primary = self::createStub(Connection::class);
        $this->replica = self::createStub(Connection::class);

        $this->subject = new DoctrineConnectionManager($this->primary, $this->replica);
    }

    public function testPrimaryConnectionReturnedIfTransactionActive(): void
    {
        // arrange
        $this->primary->method('isTransactionActive')->willReturn(true);

        // act
        $result = $this->subject->getConnection();

        // assert
        self::assertSame($this->primary, $result);
    }

    public function testReplicaConnectionReturnedIfTransactionNotActive(): void
    {
        // arrange
        $this->primary->method('isTransactionActive')->willReturn(false);

        // act
        $result = $this->subject->getConnection();

        // assert
        self::assertSame($this->replica, $result);
    }
}
