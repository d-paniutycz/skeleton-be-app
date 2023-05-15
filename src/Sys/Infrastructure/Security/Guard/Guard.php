<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Security\Guard;

use Attribute;
use Sys\Infrastructure\Security\Guard\Strategy\GuardStrategy;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Guard
{
    public function __construct(
        public readonly GuardStrategy $strategy,
    ) {
    }
}
