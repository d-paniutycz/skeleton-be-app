<?php

declare(strict_types=1);

namespace Sys\Framework\Domain\Value;

use Exception;
use Symfony\Component\Uid\Ulid;

abstract class UniqueStringValue extends StringValue
{
    protected string $value;

    public static function generate(): static
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
