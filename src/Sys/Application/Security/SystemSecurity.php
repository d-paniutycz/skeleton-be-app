<?php

declare(strict_types=1);

namespace Sys\Application\Security;

use Symfony\Component\Security\Core\User\UserInterface;
use Sys\Domain\Value\Role;

interface SystemSecurity
{
    public function isUserAuthenticated(): bool;

    public function getUserId(): string;

    public function getUserRole(): Role;

    public function login(UserInterface $user): void;
}
