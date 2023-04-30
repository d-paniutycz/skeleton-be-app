<?php

declare(strict_types=1);

namespace Sys\Application\Messenger\Bus;

use Sys\Application\Messenger\Message\EventMessage;

interface EventBus
{
    public function dispatch(EventMessage $message): void;
}
