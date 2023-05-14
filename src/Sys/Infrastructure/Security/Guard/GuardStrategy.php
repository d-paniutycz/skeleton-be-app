<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Security\Guard;

interface GuardStrategy
{
    public function apply(): void;
}
