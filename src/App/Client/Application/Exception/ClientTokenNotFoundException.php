<?php

declare(strict_types=1);

namespace App\Client\Application\Exception;

use Symfony\Component\HttpFoundation\Response;
use Sys\Infrastructure\Exception\Abstract\ApplicationException;

class ClientTokenNotFoundException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct('Client token not found, authentication is required.');
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }
}
