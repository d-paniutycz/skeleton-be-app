<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Exception;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Sys\Infrastructure\Exception\Problem\ApiProblemResponseBuilder;
use Sys\Infrastructure\Messenger\MessengerPackingService;
use Throwable;

#[AsEventListener]
class ExceptionEventListener
{
    /** @var class-string[] */
    private array $exceptionWhiteList = [];

    public function __construct(
        private readonly ApiProblemResponseBuilder $responseBuilder,
        private readonly MessengerPackingService $packingService,
    ) {
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof HandlerFailedException) {
            $exception = $this->packingService->unpackException($exception);

            if (is_null($exception)) {
                return;
            }
        }

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
