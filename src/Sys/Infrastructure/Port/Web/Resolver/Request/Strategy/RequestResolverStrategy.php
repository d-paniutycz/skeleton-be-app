<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Port\Web\Resolver\Request\Strategy;

use Symfony\Component\HttpFoundation\Request;

interface RequestResolverStrategy
{
    /**
     * @return array<array-key, mixed>
     */
    public function resolve(Request $request): array;
}
