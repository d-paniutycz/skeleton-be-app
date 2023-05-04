<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Port\Web\Resolver\Request\Strategy;

use Exception;
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
     * @return array<mixed>
     */
    public function resolve(Request $request): array
    {
        $data = $request->toArray();

        if (!is_null($this->key)) {
            if (array_key_exists($this->key, $data)) {
                return $data[$this->key];
            }

            throw new Exception('wymysl cos');
        }

        return $data;
    }
}
