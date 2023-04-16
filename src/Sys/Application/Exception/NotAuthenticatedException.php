<?php

declare(strict_types=1);

namespace Sys\Application\Exception;

use Symfony\Component\HttpFoundation\Response;
use Sys\Infrastructure\Exception\Abstract\ApplicationException;

class NotAuthenticatedException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct('Not authenticated to access this resource.');
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }
}
