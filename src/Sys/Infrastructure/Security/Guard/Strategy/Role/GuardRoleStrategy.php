<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Security\Guard\Strategy\Role;

use Sys\Domain\Value\Role;
use Sys\Infrastructure\Security\Guard\Strategy\GuardStrategy;

interface GuardRoleStrategy extends GuardStrategy
{
    public function assert(Role $role): void;
}
