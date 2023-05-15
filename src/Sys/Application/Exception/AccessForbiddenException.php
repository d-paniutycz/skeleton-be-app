<?php

declare(strict_types=1);

namespace Sys\Application\Exception;

use Symfony\Component\HttpFoundation\Response;
use Sys\Infrastructure\Exception\Abstract\ApplicationException;

class AccessForbiddenException extends ApplicationException
{
    public function __construct(
        public string $permissionType,
    ) {
        parent::__construct('Access forbidden to this resource.');
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_FORBIDDEN;
    }
}
