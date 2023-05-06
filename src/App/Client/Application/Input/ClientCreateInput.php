<?php

declare(strict_types=1);

namespace App\Client\Application\Input;

use Sys\Infrastructure\Port\Web\Resolver\Request\ResolvableRequest;
use Sys\Infrastructure\Port\Web\Resolver\Request\Strategy\JsonContentResolverStrategy;
use Sys\Infrastructure\Port\Web\Resolver\Request\Strategy\RequestResolverStrategy;
use Symfony\Component\Validator\Constraints as Assert;

final class ClientCreateInput implements ResolvableRequest
{
    #[Assert\Email]
    public readonly string $email;

    #[Assert\Range(min: 16, max: 32)]
    public readonly int $age;

    public function __construct(string $email, int $age)
    {
        $this->email = $email;
        $this->age = $age;
    }

    public static function getRequestResolver(): RequestResolverStrategy
    {
        return new JsonContentResolverStrategy();
    }
}
