<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Security\Guard;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;

#[AsEventListener]
class GuardAttributeListener
{
    public function __invoke(ControllerArgumentsEvent $event): void
    {
        /** @var ?Guard[] $guards */
        $guards = $event->getAttributes()[Guard::class] ?? [];
        if (empty($guards)) {
            return;
        }

        foreach ($guards as $guard) {
            $this->process($guard->strategy);
        }
    }

    private function process(GuardStrategy $strategy): void
    {
        $strategy->apply();
    }
}
