<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Exception;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Exception\RequestExceptionInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Sys\Infrastructure\Exception\Abstract\ApplicationException;
use Sys\Infrastructure\Exception\Problem\ApiProblemExceptionMapper;
use Sys\Infrastructure\Exception\Problem\ApiProblemResponseBuilder;
use Throwable;

#[AsEventListener]
class ExceptionEventListener
{
    /**
     * @var array<class-string>
     */
    private array $exceptionWhiteList = [
        ValidationFailedException::class,
    ];

    public function __construct(
        private readonly ApiProblemExceptionMapper $exceptionMapper,
        private readonly ApiProblemResponseBuilder $responseBuilder,
    ) {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof HttpExceptionInterface || $this->isOnWhiteList($exception)) {
            $apiProblem = $this->exceptionMapper->map($exception);

            if ($exception instanceof ValidationFailedException) {
                $apiProblem->addAdditional('violations', $exception->getViolations());
            }

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
