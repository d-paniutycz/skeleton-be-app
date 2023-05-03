<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Exception\Problem;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

final class ApiProblemResponseBuilder
{
    public function __construct(
        private readonly SerializerInterface $serializer
    ) {
    }

    public function build(ApiProblem $apiProblem, ?Throwable $exception = null): Response
    {
        $headers = $this->createHeaders($exception)->all();
        $content = $this->serializer->serialize($apiProblem, 'json');

        return new Response($content, $apiProblem->getStatus(), $headers);
    }

    private function createHeaders(?Throwable $exception): ResponseHeaderBag
    {
        $headers = new ResponseHeaderBag();

        if ($exception instanceof HttpExceptionInterface) {
            $headers->add(
                $exception->getHeaders()
            );
        }

        $headers->set('Content-Type', 'application/problem+json');

        return $headers;
    }
}
