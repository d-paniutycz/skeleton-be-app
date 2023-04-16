<?php

declare(strict_types=1);

namespace Sys\Domain\Value\Basic;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use Stringable;
use Sys\Application\Exception\Input\InputStringValueException;

abstract class DateTimeValue implements Valuable, Stringable
{
    private const DEFAULT_FORMAT = 'Y-m-d\TH:i:s.vp';

    protected readonly DateTimeImmutable $value;

    public function __construct(
        DateTimeInterface|string $value,
    ) {
        if (is_string($value)) {
            if (!strtotime($value)) {
                throw new InputStringValueException('Invalid DateTime string', $value);
            }
        }

        $this->value = $value instanceof DateTimeInterface
            ? DateTimeImmutable::createFromInterface($value)
            : new DateTimeImmutable($value);
    }

    public function getValue(): DateTime
    {
        return DateTime::createFromImmutable($this->value);
    }

    public function equals(Valuable $value): bool
    {
        /** @var mixed $value */
        $value = $value->getValue();

        if ($value instanceof DateTimeInterface) {
            return strval($this) === $value->format(self::DEFAULT_FORMAT);
        }

        if ($value instanceof Stringable) {
            return strval($this) === strval($value);
        }

        if (is_string($value)) {
            return strval($this) === $value;
        }

        return false;
    }

    public function jsonSerialize(): string
    {
        return strval($this);
    }

    public function __toString(): string
    {
        return $this->value->format(self::DEFAULT_FORMAT);
    }
}
