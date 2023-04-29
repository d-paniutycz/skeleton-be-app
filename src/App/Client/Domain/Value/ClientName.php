<?php

declare(strict_types=1);

namespace App\Client\Domain\Value;

use Doctrine\ORM\Mapping as ORM;
use Stringable;

#[ORM\Embeddable]
class ClientName implements Stringable
{
    #[ORM\Column]
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
