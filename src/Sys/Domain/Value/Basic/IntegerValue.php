<?php

declare(strict_types=1);

namespace Sys\Domain\Value\Basic;

use Stringable;

abstract class IntegerValue implements Valuable
{
    public function __construct(
        protected readonly int $value,
    ) {
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function equals(Valuable $value): bool
    {
        return $this->value === $value->getValue();
    }

    public function jsonSerialize(): int
    {
        return $this->value;
    }
}
