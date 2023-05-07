<?php

declare(strict_types=1);

namespace Sys\Domain\Value;

use Sys\Application\Exception\InputStringValueException;
use Sys\Domain\Value\Basic\StringValue;

abstract class EmailValue extends StringValue
{
    final public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InputStringValueException('Invalid email address', $value);
        }

        parent::__construct($value);
    }
}
