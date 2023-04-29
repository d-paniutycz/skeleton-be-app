<?php

declare(strict_types=1);

namespace Sys\Cqrs\Application\Bus;

use Sys\Cqrs\Application\Message\EventMessage;

interface EventBus
{
    public function dispatch(EventMessage $message): void;
}
