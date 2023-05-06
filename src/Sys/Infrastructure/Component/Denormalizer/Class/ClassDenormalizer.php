<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Component\Denormalizer\Class;

interface ClassDenormalizer
{
    /**
     * @param array<array-key, mixed> $data
     * @param class-string $type
     */
    public function denormalize(array $data, string $type): object;
}
