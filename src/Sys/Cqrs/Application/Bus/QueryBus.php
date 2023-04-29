<?php

declare(strict_types=1);

namespace Sys\Cqrs\Application\Bus;

use Sys\Cqrs\Application\Message\QueryMessage;

interface QueryBus
{
    public function dispatch(QueryMessage $message): mixed;
}
