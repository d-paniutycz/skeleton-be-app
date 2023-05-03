<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Exception;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Sys\Infrastructure\Exception\Problem\ApiProblem;
use Sys\Infrastructure\Exception\Problem\ApiProblemExceptionMapper;
use Sys\Infrastructure\Exception\Problem\ApiProblemResponseBuilder;
use Throwable;

#[AsEventListener]
class ExceptionEventListener
{
    /**
     * @var array<class-string>
     */
    private array $exceptionWhiteList = [];

    public function __construct(
        private readonly ApiProblemExceptionMapper $exceptionMapper,
        private readonly ApiProblemResponseBuilder $responseBuilder,
    ) {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof ApplicationException || $this->isOnWhiteList($exception)) {
            $apiProblem = $this->exceptionMapper->map($exception);

            $event->setResponse(
                $this->responseBuilder->build($apiProblem, $exception)
            );
        }
    }

    private function isOnWhiteList(Throwable $exception): bool
    {
        return in_array(get_class($exception), $this->exceptionWhiteList);
    }
}
