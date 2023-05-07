<?php

declare(strict_types=1);

namespace Sys\Domain\Value\Basic;

abstract class BooleanValue implements Valuable
{
    public function __construct(
        protected readonly bool $value
    ) {
    }

    public function getValue(): bool
    {
        return $this->value;
    }

    public function equals(Valuable $value): bool
    {
        return $this->value === $value->getValue();
    }

    public function jsonSerialize(): bool
    {
        return $this->value;
    }
}
