<?php

declare(strict_types=1);

namespace App\Client\Application\Input;

use Sys\Infrastructure\Port\Web\Resolver\Request\Resolvable;
use Sys\Infrastructure\Port\Web\Resolver\Request\Strategy\JsonContentResolverStrategy;
use Sys\Infrastructure\Port\Web\Resolver\Request\Strategy\ResolverStrategy;
use Symfony\Component\Validator\Constraints as Assert;

class ClientCreateInput implements Resolvable
{
    #[Assert\Type('string')]
    public readonly mixed $email;

    #[Assert\Type('string')]
    public readonly string $name;

    #[Assert\Type('int')]
    public readonly float $age;

    public function __construct(
        mixed $email,
        string $name,
        float $age,
    ) {
        $this->email = $email;
        $this->name = $name;
        $this->age = $age;
    }

    public static function getStrategy(): ResolverStrategy
    {
        return new JsonContentResolverStrategy();
    }
}
