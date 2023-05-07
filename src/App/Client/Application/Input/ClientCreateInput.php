<?php

declare(strict_types=1);

namespace App\Client\Application\Input;

use Sys\Infrastructure\Port\Web\Resolver\Request\ResolvableRequest;
use Sys\Infrastructure\Port\Web\Resolver\Request\Strategy\JsonContentResolverStrategy;
use Sys\Infrastructure\Port\Web\Resolver\Request\Strategy\RequestResolverStrategy;
use Symfony\Component\Validator\Constraints as Assert;

readonly class ClientCreateInput implements ResolvableRequest
{
    public function __construct(
        #[Assert\Type('alnum')]
        #[Assert\Length(min: 8, max: 32)]
        public string $username,
        #[Assert\Length(min: 8, max: 32)]
        public string $password,
    ) {
    }

    public static function getRequestResolver(): RequestResolverStrategy
    {
        return new JsonContentResolverStrategy();
    }
}
