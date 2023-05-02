<?php

declare(strict_types=1);

namespace Sys\Domain\Value;

use Symfony\Component\Uid\Ulid;
use Sys\Application\Exception\InvalidStringValueException;

abstract class UniqueStringIdValue extends StringValue
{
    public const PATTERN = '[0-9A-Z]{26}';

    final public static function generate(): static
    {
        return new static(
            Ulid::generate()
        );
    }

    final public function __construct(string $value)
    {
        if (!Ulid::isValid($value)) {
            throw new InvalidStringValueException('Invalid ULID identifier', $value);
        }

        parent::__construct($value);
    }
}
