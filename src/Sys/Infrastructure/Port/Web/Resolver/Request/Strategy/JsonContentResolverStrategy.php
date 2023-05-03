<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Port\Web\Resolver\Request\Strategy;

use Symfony\Component\HttpFoundation\Exception\JsonException;
use Symfony\Component\HttpFoundation\Request;

class JsonContentResolverStrategy implements ResolverStrategy
{
    public function __construct(
        private readonly ?string $key = null,
    ) {
    }

    /**
     * @psalm-suppress MixedReturnStatement
     * @psalm-suppress MixedInferredReturnType
     * @return string[]
     */
    public function resolve(Request $request): array
    {
        try {
            $data = $request->toArray();
        } catch (JsonException $exception) {
            throw $exception;
        }

        return is_null($this->key) ? $data : $data[$this->key] ?? [];
    }
}
