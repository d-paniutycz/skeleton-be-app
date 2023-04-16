<?php

declare(strict_types=1);

namespace App\Client\Application\Exception;

use App\Client\Domain\Value\ClientId;
use Symfony\Component\HttpFoundation\Response;
use Sys\Infrastructure\Exception\Abstract\ApplicationException;

class ClientBlockedException extends ApplicationException
{
    public function __construct(
        public readonly ClientId $clientId,
    ) {
        parent::__construct('Client is blocked.');
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_FORBIDDEN;
    }
}
