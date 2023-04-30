<?php

declare(strict_types=1);

namespace Sys\Application\Messenger\Bus;

use Sys\Application\Messenger\Message\CommandMessage;

interface CommandBus
{
    public function dispatch(CommandMessage $message): void;
}
