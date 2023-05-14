<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Security\Guard;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class Guard
{
    public function __construct(
        public readonly GuardStrategy $strategy,
    ) {
    }
}
