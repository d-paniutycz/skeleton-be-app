<?php

declare(strict_types=1);

namespace Sys\Application\Exception;

use Symfony\Component\HttpFoundation\Response;
use Sys\Domain\Value\Role;
use Sys\Infrastructure\Exception\Abstract\ApplicationException;

class InsufficientRoleException extends ApplicationException
{
    public function __construct(
        public Role $currentRole,
    ) {
        parent::__construct('Insufficient role to access this resource.');
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_FORBIDDEN;
    }
}
