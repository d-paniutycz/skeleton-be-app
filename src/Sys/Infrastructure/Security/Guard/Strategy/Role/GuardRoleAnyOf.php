<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Security\Guard\Strategy\Role;

use Sys\Application\Exception\AccessForbiddenException;
use Sys\Domain\Value\Role;

class GuardRoleAnyOf implements GuardRoleStrategy
{
    /** @var Role[] */
    private array $desired;

    public function __construct(Role ...$roles)
    {
        $this->desired = $roles;
    }

    public function assert(array $roles): void
    {
        foreach ($this->desired as $role) {
            if (in_array($role->getValue(), $roles)) {
                return;
            }
        }

        throw new AccessForbiddenException('role');
    }
}
