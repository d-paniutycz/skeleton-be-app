<?php

declare(strict_types=1);

namespace Sys\Domain\Value;

use Exception;
use Symfony\Component\Uid\Ulid;

abstract class UniqueStringValue extends StringValue
{
    public const PATTERN = '[0-9A-Z]{26}';

    protected string $value;

    final public static function generate(): static
    {
        return new static(
            Ulid::generate()
        );
    }

    final public function __construct(string $value)
    {
        if (!Ulid::isValid($value)) {
            throw new Exception('Invalid ULID identifier: ' . $value);
        }

        parent::__construct($value);
    }
}
