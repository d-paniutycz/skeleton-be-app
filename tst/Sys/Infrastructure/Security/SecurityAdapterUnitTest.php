<?php

namespace Sys\Test\Infrastructure\Security;

use RuntimeException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Sys\Application\Exception\NotAuthenticatedException;
use Sys\Domain\Value\Role;
use Sys\Infrastructure\Security\SecurityAdapter;
use Sys\Infrastructure\Test\Type\UnitTest;

class SecurityAdapterUnitTest extends UnitTest
{
    private readonly UserInterface $user;
    private readonly Security $security;

    protected function setUp(): void
    {
        $this->user = self::createStub(UserInterface::class);
        $this->security  = self::createStub(Security::class);
    }

    public function testThrowingExceptionOnUnauthenticatedUser(): void
    {
        // arrange
        $this->security->method('getUser')->willReturn(null);

        $subject = new SecurityAdapter($this->security);

        // assert
        self::expectException(NotAuthenticatedException::class);

        // act
        $subject->getUserId();
    }

    public function testIfUserIsAuthenticated(): void
    {
        // arrange
        $this->security->method('getUser')->willReturn($this->user);

        $subject = new SecurityAdapter($this->security);

        // assert
        self::assertTrue(
            $subject->isUserAuthenticated()
        );
    }

    public function testThrowingExceptionOnUserWithoutRoles(): void
    {
        // arrange
        $this->user->method('getRoles')->willReturn([]);
        $this->security->method('getUser')->willReturn($this->user);

        $subject = new SecurityAdapter($this->security);

        // assert
        self::expectException(RuntimeException::class);

        // act
        $subject->getUserRole();
    }

    public function testGettingUserRole(): void
    {
        // arrange
        $this->user->method('getRoles')->willReturn([Role::REGULAR->getValue()]);
        $this->security->method('getUser')->willReturn($this->user);

        $subject = new SecurityAdapter($this->security);

        // act
        $role = $subject->getUserRole();

        // assert
        self::assertEquals(Role::REGULAR, $role);
    }
}
