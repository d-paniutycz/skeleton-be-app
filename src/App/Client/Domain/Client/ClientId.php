<?php

declare(strict_types=1);

namespace App\Client\Domain\Client;

use Doctrine\ORM\Mapping as ORM;
use Stringable;

#[ORM\Embeddable]
class ClientId implements Stringable
{
    #[ORM\Id, ORM\Column]
    private readonly string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
