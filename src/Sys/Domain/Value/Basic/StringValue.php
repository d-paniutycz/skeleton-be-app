<?php

declare(strict_types=1);

namespace Sys\Domain\Value\Basic;

use Stringable;

abstract class StringValue implements Valuable, Stringable
{
    public function __construct(
        protected readonly string $value,
    ) {
    }

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

    public function __toString(): string
    {
        return $this->value;
    }
}
