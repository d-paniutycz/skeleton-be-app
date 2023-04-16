<?php

namespace Sys\Test\Infrastructure\Security\Guard;

use Sys\Application\Exception\InsufficientRoleException;
use Sys\Domain\Value\Role;
use Sys\Infrastructure\Security\Guard\Guard;
use Sys\Infrastructure\Security\Guard\Strategy\GuardStrategy;
use Sys\Infrastructure\Test\Type\UnitTest;

class GuardUnitTest extends UnitTest
{
    public function testDefaultStrategyIsNotAllowingBlockedRole(): void
    {
        // arrange
        $subject = new Guard();

        // assert
        self::expectException(InsufficientRoleException::class);

        // act
        $subject->getStrategy()->assert(Role::BLOCKED);
    }

    public function testGuardStrategyCanBeSet(): void
    {
        // arrange
        $strategy = self::createStub(GuardStrategy::class);

        // act
        new Guard($strategy);

        // assert
        self::assertTrue(true);
    }
}
