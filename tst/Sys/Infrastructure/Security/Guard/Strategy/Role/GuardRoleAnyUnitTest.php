<?php

namespace Sys\Test\Infrastructure\Security\Guard\Strategy\Role;

use Sys\Application\Exception\InsufficientRoleException;
use Sys\Domain\Value\Role;
use Sys\Infrastructure\Security\Guard\Strategy\Role\GuardRoleAny;
use Sys\Infrastructure\Test\Type\UnitTest;

class GuardRoleAnyUnitTest extends UnitTest
{
    private readonly GuardRoleAny $subject;

    protected function setUp(): void
    {
        $this->subject = new GuardRoleAny(Role::MASTER, Role::REGULAR);
    }

    public function testAllowingRolesOnList(): void
    {
        // act
        $this->subject->assert(Role::REGULAR);

        // assert
        self::assertTrue(true);
    }

    public function testNotAllowingRolesOutOfList(): void
    {
        // assert
        self::expectException(InsufficientRoleException::class);

        // act
        $this->subject->assert(Role::BLOCKED);
    }
}
