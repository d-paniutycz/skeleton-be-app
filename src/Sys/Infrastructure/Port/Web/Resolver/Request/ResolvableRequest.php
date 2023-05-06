<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Port\Web\Resolver\Request;

use Sys\Infrastructure\Port\Web\Resolver\Request\Strategy\RequestResolverStrategy;

interface ResolvableRequest
{
    public static function getRequestResolver(): RequestResolverStrategy;
}
