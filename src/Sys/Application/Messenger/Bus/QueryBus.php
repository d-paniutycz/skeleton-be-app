<?php

declare(strict_types=1);

namespace Sys\Application\Messenger\Bus;

use Sys\Application\Messenger\Message\QueryMessage;

interface QueryBus
{
    public function dispatch(QueryMessage $message): mixed;
}
