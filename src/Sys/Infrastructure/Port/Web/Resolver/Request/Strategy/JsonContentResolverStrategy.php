<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Port\Web\Resolver\Request\Strategy;

use Symfony\Component\HttpFoundation\Request;

class JsonContentResolverStrategy implements RequestResolverStrategy
{
    public function __construct(
        private readonly ?string $key = null,
    ) {
    }

    public function resolve(Request $request): array
    {
        $data = $request->toArray();

        if (is_null($this->key)) {
            return $data;
        }

        if (array_key_exists($this->key, $data)) {
            /** @var mixed $data */
            $data = $data[$this->key];

            return is_array($data) ? $data : [];
        }

        return [];
    }
}
