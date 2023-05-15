<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Security\Guard\Strategy\Role;

use Sys\Infrastructure\Security\Guard\Strategy\GuardStrategy;

interface GuardRoleStrategy extends GuardStrategy
{
    /**
     * @param array<array-key, string> $roles
     */
    public function assert(array $roles): void;
}
