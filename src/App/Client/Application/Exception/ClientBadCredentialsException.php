<?php

declare(strict_types=1);

namespace App\Client\Application\Exception;

use Symfony\Component\HttpFoundation\Response;
use Sys\Infrastructure\Exception\Abstract\ApplicationException;

class ClientBadCredentialsException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct('Bad client credentials.');
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }
}
