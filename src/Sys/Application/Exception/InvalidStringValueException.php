<?php

declare(strict_types=1);

namespace Sys\Application\Exception;

use Sys\Infrastructure\Exception\Abstract\ApplicationException;

final class InvalidStringValueException extends ApplicationException
{
    public function __construct(
        string $message,
        public readonly string $value,
    ) {
        parent::__construct($message . ': ' . $this->value);
    }
}
