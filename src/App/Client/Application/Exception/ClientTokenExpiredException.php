<?php

declare(strict_types=1);

namespace App\Client\Application\Exception;

use App\Client\Domain\Value\Token\ClientTokenExpiresAt;
use Symfony\Component\HttpFoundation\Response;
use Sys\Infrastructure\Exception\Abstract\ApplicationException;

class ClientTokenExpiredException extends ApplicationException
{
    public function __construct(
        public readonly ClientTokenExpiresAt $expiredAt,
    ) {
        parent::__construct('Client token expired, authentication is required.');
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }
}
