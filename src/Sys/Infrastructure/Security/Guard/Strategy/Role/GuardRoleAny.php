<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Security\Guard\Strategy\Role;

use Sys\Application\Exception\InsufficientRoleException;
use Sys\Domain\Value\Role;

class GuardRoleAny implements GuardRoleStrategy
{
    /** @var Role[] */
    private array $roles;

    public function __construct(Role ...$roles)
    {
        $this->roles = $roles;
    }

    public function assert(Role $role): void
    {
        if (in_array($role, $this->roles)) {
            return;
        }

        throw new InsufficientRoleException($role);
    }
}
