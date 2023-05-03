<?php

declare(strict_types=1);

namespace Sys\Domain\Value;

use Sys\Application\Exception\InvalidStringValueException;

abstract class EmailValue extends StringValue
{
    final public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidStringValueException('Invalid email address', $value);
        }

        parent::__construct($value);
    }
}
