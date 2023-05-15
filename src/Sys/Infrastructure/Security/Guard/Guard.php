<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Security\Guard;

use Attribute;
use Sys\Domain\Value\Role;
use Sys\Infrastructure\Security\Guard\Strategy\GuardStrategy;
use Sys\Infrastructure\Security\Guard\Strategy\Role\GuardRoleNot;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Guard
{
    public readonly GuardStrategy $strategy;

    public function __construct(
        ?GuardStrategy $strategy = null,
    ) {
        $this->strategy = is_null($strategy)
            ? new GuardRoleNot(Role::BLOCKED)
            : $strategy;
    }
}
