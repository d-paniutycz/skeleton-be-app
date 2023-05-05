<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Exception;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
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
        private readonly ApiProblemResponseBuilder $responseBuilder,
    ) {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof HttpExceptionInterface || $this->isOnWhiteList($exception)) {
            $event->setResponse(
                $this->responseBuilder->buildFromException($exception)
            );
        }
    }

    private function isOnWhiteList(Throwable $exception): bool
    {
        return in_array(get_class($exception), $this->exceptionWhiteList);
    }
}
