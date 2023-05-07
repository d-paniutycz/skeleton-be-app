<?php

declare(strict_types=1);

namespace Sys\Application\Exception\Input;

use Sys\Infrastructure\Exception\Abstract\ApplicationException;

class InputStringValueException extends ApplicationException
{
    public function __construct(
        string $message,
        public readonly string $value,
    ) {
        parent::__construct($message . ': ' . $this->value);
    }
}
