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
readonly class GuardControllerListener
{
    public function __construct(
        private GuardProcessor $guardProcessor,
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
            $this->guardProcessor->process($guard);
        }
    }
}
