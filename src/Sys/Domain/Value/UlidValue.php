<?php

declare(strict_types=1);

namespace Sys\Domain\Value;

use Symfony\Component\Uid\Ulid;
use Sys\Application\Exception\Input\InputStringValueException;
use Sys\Domain\Value\Basic\StringValue;

abstract class UlidValue extends StringValue
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
            throw new InputStringValueException('Invalid ULID identifier', $value);
        }

        parent::__construct($value);
    }
}
