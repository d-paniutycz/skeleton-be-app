<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Security\Guard;

use RuntimeException;
use Sys\Application\Security\SystemSecurity;
use Sys\Infrastructure\Security\Guard\Strategy\Role\GuardRoleStrategy;

readonly class GuardProcessor
{
    public function __construct(
        private SystemSecurity $security,
    ) {
    }

    public function process(Guard $guard): void
    {
        $strategy = $guard->getStrategy();
        if ($strategy instanceof GuardRoleStrategy) {
            $strategy->assert(
                $this->security->getUserRole()
            );

            return;
        }

        throw new RuntimeException('Guard has not applied any assertions.');
    }
}
