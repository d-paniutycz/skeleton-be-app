<?php

declare(strict_types=1);

namespace Sys\Application\Exception\Input;

use Sys\Infrastructure\Exception\Abstract\ApplicationException;

class InputPropertyTypeException extends ApplicationException
{
    private const TEMPLATE = 'Expected type of %s but %s provided.';

    public function __construct(
        public readonly string $property,
        public readonly string $expectedType,
        public readonly string $providedType,
    ) {
        parent::__construct(
            sprintf(self::TEMPLATE, $this->expectedType, $this->providedType)
        );
    }
}
