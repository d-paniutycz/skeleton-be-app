<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Security\Guard;

use RuntimeException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use Sys\Application\Security\SystemSecurity;
use Sys\Infrastructure\Security\Guard\Strategy\GuardStrategy;
use Sys\Infrastructure\Security\Guard\Strategy\Role\GuardRoleStrategy;

#[AsEventListener]
readonly class GuardAttributeListener
{
    public function __construct(
        private SystemSecurity $security,
    ) {
    }

    public function __invoke(ControllerArgumentsEvent $event): void
    {
        /** @var ?Guard[] $guards */
        $guards = $event->getAttributes()[Guard::class] ?? [];
        if (empty($guards)) {
            return;
        }

        foreach ($guards as $guard) {
            $this->apply($guard->strategy);
        }
    }

    private function apply(GuardStrategy $strategy): void
    {
        if ($strategy instanceof GuardRoleStrategy) {
            $strategy->assert(
                $this->security->getUserRole()
            );

            return;
        }

        throw new RuntimeException('Guard has not applied any assertions.');
    }
}
