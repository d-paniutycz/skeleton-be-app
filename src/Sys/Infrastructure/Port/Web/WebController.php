<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Port\Web;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sys\Application\Messenger\Bus\CommandBus;
use Sys\Application\Messenger\Bus\QueryBus;
use Sys\Application\Messenger\Message\QueryMessage;
use Sys\Infrastructure\Component\Serializer\PublicPropertySerializer;

abstract class WebController
{
    public function __construct(
        protected readonly PublicPropertySerializer $serializer,
        protected readonly CommandBus $commandBus,
        protected readonly QueryBus $queryBus,
    ) {
    }

    protected function responseFromQuery(QueryMessage $message): Response
    {
        $data = $this->serializer->serialize(
            $this->queryBus->dispatch($message)
        );

        return new JsonResponse($data, json: true);
    }
}
