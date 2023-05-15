<?php

declare(strict_types=1);

namespace Sys\Application\Security;

use Symfony\Component\Security\Core\User\UserInterface;

interface SystemSecurity
{
    public function getUserId(): string;

    /**
     * @return array<array-key, string>
     */
    public function getUserRoles(): array;

    public function login(UserInterface $user): void;
}
