<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Exception\Problem;

use ReflectionClass;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

final class ApiProblemExceptionMapper
{
    private const ADDITIONAL_KEY_BLACK_LIST = ['token', 'secret', 'password', 'xdebug_message'];

    private const DEFAULT_STATUS_CODE = Response::HTTP_BAD_REQUEST;

    private const DEFAULT_DESCRIPTION = 'about:blank';

    public function map(Throwable $exception): ApiProblem
    {
        return new ApiProblem(
            $this->getType($exception),
            $this->getTitle($exception),
            $this->getDetail($exception),
            $this->getStatus($exception),
            $this->getAdditional($exception),
        );
    }

    private function getClassName(object $object): ?string
    {
        $reflect = new ReflectionClass($object);
        if ($reflect->isAnonymous()) {
            return null;
        }

        return $reflect->getName();
    }

    private function getClassShortName(object $object): ?string
    {
        $reflect = new ReflectionClass($object);
        if ($reflect->isAnonymous()) {
            return null;
        }

        return $reflect->getShortName();
    }

    private function getType(Throwable $exception): string
    {
        $name = $this->getClassName($exception);

        return is_string($name) ? 'urn:id:' . ApiProblem::tokenizeType($name) : self::DEFAULT_DESCRIPTION;
    }

    private function getTitle(Throwable $exception): string
    {
        $name = $this->getClassShortName($exception);

        $title = is_string($name)
            ? $this->getTitleFromClassName($name)
            : $this->getTitleFromStatus($exception);

        return is_string($title) ? ucfirst(strtolower($title)) : self::DEFAULT_DESCRIPTION;
    }

    private function getTitleFromClassName(string $name): string
    {
        $words = preg_split('/(?=[A-Z])/', $name, flags: PREG_SPLIT_NO_EMPTY);

        return is_array($words) ? implode(' ', $words) : $name;
    }

    private function getStatus(Throwable $exception): int
    {
        if (!$exception instanceof HttpExceptionInterface) {
            return self::DEFAULT_STATUS_CODE;
        }

        return $exception->getStatusCode();
    }

    private function getTitleFromStatus(Throwable $exception): ?string
    {
        /** @var array<int, string> $statusTexts */
        $statusTexts = Response::$statusTexts;

        return $statusTexts[$this->getStatus($exception)] ?? null;
    }

    private function getDetail(Throwable $exception): string
    {
        $detail = $exception->getMessage();

        return empty($detail) ? self::DEFAULT_DESCRIPTION : $detail;
    }

    /**
     * @return array<string, mixed>
     */
    private function getAdditional(Throwable $exception): array
    {
        $list = get_object_vars($exception);

        return array_diff_key($list, array_flip(self::ADDITIONAL_KEY_BLACK_LIST));
    }
}
