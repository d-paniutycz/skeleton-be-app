<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Sys\Application\Messenger\Bus\CommandBus;
use Sys\Application\Messenger\Bus\QueryBus;
use Sys\Application\Messenger\Message\QueryMessage;

abstract class WebController
{
    final public function __construct(
        protected CommandBus $commandBus,
        protected QueryBus $queryBus,
    ) {
    }

    protected function jsonResponseFromQuery(QueryMessage $message, int $status = 200): JsonResponse
    {
        return new JsonResponse(
            $this->queryBus->dispatch($message),
            $status,
        );
    }
}
