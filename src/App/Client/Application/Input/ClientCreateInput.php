<?php

declare(strict_types=1);

namespace App\Client\Application\Input;

use Sys\Infrastructure\Port\Web\Resolver\Request\Resolvable;
use Sys\Infrastructure\Port\Web\Resolver\Request\Strategy\JsonContentResolverStrategy;
use Sys\Infrastructure\Port\Web\Resolver\Request\Strategy\ResolverStrategy;
use Symfony\Component\Validator\Constraints as Assert;

class ClientCreateInput implements Resolvable
{
    #[Assert\Email]
    public readonly string $email;

    //#[Assert\Range(min: 18)]
    #[Assert\NotNull]
    public readonly ?int $age;

    public static function getStrategy(): ResolverStrategy
    {
        return new JsonContentResolverStrategy();
    }
}
