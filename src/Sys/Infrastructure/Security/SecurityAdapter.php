<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Security;

use RuntimeException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Sys\Application\Exception\NotAuthenticatedException;
use Sys\Application\Security\SystemSecurity;
use Sys\Domain\Value\Role;

readonly class SecurityAdapter implements SystemSecurity
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function isUserAuthenticated(): bool
    {
        return null !== $this->security->getUser();
    }

    private function getUser(): UserInterface
    {
        return $this->security->getUser()
            ?? throw new NotAuthenticatedException();
    }

    public function getUserId(): string
    {
        return $this->getUser()->getUserIdentifier();
    }

    public function getUserRole(): Role
    {
        $roles = $this->getUser()->getRoles();
        if (empty($roles)) {
            throw new RuntimeException('User id: ' . $this->getUserId() . ' has no roles');
        }

        return Role::from($roles[0]);
    }

    public function login(UserInterface $user): void
    {
        $this->security->login($user);
    }
}
