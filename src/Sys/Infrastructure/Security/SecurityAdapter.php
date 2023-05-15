<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Security;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Sys\Application\Exception\NotAuthenticatedException;
use Sys\Application\Security\SystemSecurity;

readonly class SecurityAdapter implements SystemSecurity
{
    public function __construct(
        private Security $security,
    ) {
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

    public function getUserRoles(): array
    {
        return $this->getUser()->getRoles();
    }

    public function login(UserInterface $user): void
    {
        $this->security->login($user);
    }
}
