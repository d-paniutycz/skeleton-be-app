<?php

declare(strict_types=1);

namespace Sys\Application\Exception;

final class InvalidStringValueException extends ApplicationException
{
    public function __construct(
        public readonly string $detail,
        public readonly string $value,
    ) {
        parent::__construct($this->detail . ': ' . $this->value);
    }
}
