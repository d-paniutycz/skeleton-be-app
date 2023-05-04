<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Port\Web\Resolver\Request\Strategy;

use Symfony\Component\HttpFoundation\Request;

interface ResolverStrategy
{
    /**
     * @return array<string, mixed>
     */
    public function resolve(Request $request): array;
}
