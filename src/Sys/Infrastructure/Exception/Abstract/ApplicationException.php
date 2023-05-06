<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Exception\Abstract;

use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

abstract class ApplicationException extends RuntimeException implements HttpExceptionInterface
{
    public function getStatusCode(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }

    /**
     * @return array<array-key, mixed>
     */
    public function getHeaders(): array
    {
        return [];
    }
}
