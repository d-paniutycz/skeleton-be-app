<?php

namespace Sys\Test\Infrastructure\Security\Guard;

use RuntimeException;
use Sys\Application\Security\SystemSecurity;
use Sys\Domain\Value\Role;
use Sys\Infrastructure\Security\Guard\Guard;
use Sys\Infrastructure\Security\Guard\GuardProcessor;
use Sys\Infrastructure\Security\Guard\Strategy\GuardStrategy;
use Sys\Infrastructure\Security\Guard\Strategy\Role\GuardRoleStrategy;
use Sys\Infrastructure\Test\Type\UnitTest;

class GuardProcessorUnitTest extends UnitTest
{
    public function testTriggeringAssertionOnRoleStrategy(): void
    {
        // arrange
        $strategy = self::createMock(GuardRoleStrategy::class);

        $security = self::createStub(SystemSecurity::class);
        $security->method('getUserRole')->willReturn(Role::BLOCKED);

        $subject = new GuardProcessor($security);

        // assert
        $strategy->expects(self::once())
            ->method('assert')
            ->with(Role::BLOCKED);

        // act
        $subject->process(
            new Guard($strategy)
        );
    }

    public function testThrowingExceptionOnUnknownStrategy(): void
    {
        // arrange
        $subject = new GuardProcessor(
            self::createStub(SystemSecurity::class)
        );

        // assert
        self::expectException(RuntimeException::class);

        // act
        $subject->process(
            new Guard(
                self::createStub(GuardStrategy::class)
            )
        );
    }
}
