<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Exception\Problem;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Sys\Infrastructure\Component\Serializer\PublicPropertySerializer;
use Throwable;

readonly class ApiProblemResponseBuilder
{
    public function __construct(
        private PublicPropertySerializer $serializer,
        private ApiProblemExceptionMapper $exceptionMapper,
    ) {
    }

    /**
     * @param array<array-key, mixed> $headers
     */
    public function build(ApiProblem $apiProblem, array $headers = []): Response
    {
        $content = $this->serializer->serialize($apiProblem);

        $headers = new ResponseHeaderBag($headers);
        $headers->set('Content-Type', 'application/problem+json');

        return new Response($content, $apiProblem->getStatus(), $headers->all());
    }

    public function buildFromException(Throwable $exception): Response
    {
        $apiProblem = $this->exceptionMapper->map($exception);

        $headers = [];
        if ($exception instanceof HttpExceptionInterface) {
            $headers = $exception->getHeaders();
        }

        return $this->build($apiProblem, $headers);
    }
}
