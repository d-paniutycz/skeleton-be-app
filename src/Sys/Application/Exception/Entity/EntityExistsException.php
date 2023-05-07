<?php

declare(strict_types=1);

namespace Sys\Application\Exception\Entity;

use Stringable;
use Sys\Infrastructure\Exception\Abstract\ApplicationException;

class EntityExistsException extends ApplicationException
{
    private const TEMPLATE = 'Entity of type %s and %s: %s exists.';

    public readonly string $type;

    public readonly string $property;

    /**
     * @param class-string $type
     */
    public function __construct(
        string $type,
        public readonly Stringable $value,
        string $property = 'id',
    ) {
        $this->type = $this->getTypeShortName($type);
        $this->property = $property;

        parent::__construct(
            sprintf(self::TEMPLATE, $this->type, $this->property, (string) $this->value)
        );
    }
}
