<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Security\Guard;

use Exception;

class GuardRole implements GuardStrategy
{
    /**
     * @param array<array-key, string> $roles
     */
    public function __construct(
        private readonly array $roles
    ) {
    }

    public function apply(): void
    {
        if (empty($this->roles)) {
            throw new Exception('empty roles');
        }
    }
}
