<?php

declare(strict_types=1);

namespace Sys\Domain\Value;

use Exception;

abstract class EmailValue extends StringValue
{
    final public function __construct(string $value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email');
        }

        parent::__construct($value);
    }
}
