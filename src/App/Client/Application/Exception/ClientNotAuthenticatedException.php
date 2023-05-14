<?php

declare(strict_types=1);

namespace App\Client\Application\Exception;

use Symfony\Component\HttpFoundation\Response;
use Sys\Infrastructure\Exception\Abstract\ApplicationException;

class ClientNotAuthenticatedException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct('Authentication is required to access this resource.');
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }
}
