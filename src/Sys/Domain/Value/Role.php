<?php

declare(strict_types=1);

namespace Sys\Domain\Value;

use Sys\Domain\Value\Basic\Valuable;

enum Role: string implements Valuable
{
    case BLOCKED = 'ROLE_BLOCKED';
    case REGULAR = 'ROLE_REGULAR';
    case MASTER = 'ROLE_MASTER';

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(Valuable $value): bool
    {
        return $this->value === $value->getValue();
    }

    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
