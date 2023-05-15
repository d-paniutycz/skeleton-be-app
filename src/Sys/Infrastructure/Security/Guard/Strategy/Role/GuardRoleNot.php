<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Security\Guard\Strategy\Role;

use Sys\Application\Exception\InsufficientRoleException;
use Sys\Domain\Value\Role;

readonly class GuardRoleNot implements GuardRoleStrategy
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
            throw new InsufficientRoleException($role);
        }
    }
}
