<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Port\Web\Resolver\Request\Strategy;

use Symfony\Component\HttpFoundation\Request;
use Sys\Application\Exception\InputPropertyTypeException;

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

            if (is_array($data)) {
                return $data;
            }

            throw new InputPropertyTypeException($this->key, 'array', gettype($data));
        }

        return [];
    }
}
