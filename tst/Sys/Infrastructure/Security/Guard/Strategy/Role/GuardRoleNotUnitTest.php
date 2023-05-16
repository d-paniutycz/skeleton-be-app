<?php

namespace Sys\Test\Infrastructure\Security\Guard\Strategy\Role;

use Sys\Application\Exception\InsufficientRoleException;
use Sys\Domain\Value\Role;
use Sys\Infrastructure\Security\Guard\Strategy\Role\GuardRoleNot;
use Sys\Infrastructure\Test\UnitTest;

class GuardRoleNotUnitTest extends UnitTest
{
    private readonly GuardRoleNot $subject;

    protected function setUp(): void
    {
        $this->subject = new GuardRoleNot(Role::BLOCKED);
    }

    public function testAllowingRolesOutOfList(): void
    {
        // act
        $this->subject->assert(Role::REGULAR);

        // assert
        self::assertTrue(true);
    }

    public function testNotAllowingRolesOnList(): void
    {
        // assert
        self::expectException(InsufficientRoleException::class);

        // act
        $this->subject->assert(Role::BLOCKED);
    }
}
