<?php

declare(strict_types=1);

namespace Sys\Cqrs\Application\Bus;

use Sys\Cqrs\Application\Message\CommandMessage;

interface CommandBus
{
    public function dispatch(CommandMessage $message): void;
}
