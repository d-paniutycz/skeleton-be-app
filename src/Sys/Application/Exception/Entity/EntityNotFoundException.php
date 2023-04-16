<?php

declare(strict_types=1);

namespace Sys\Application\Exception\Entity;

use Stringable;
use Symfony\Component\HttpFoundation\Response;
use Sys\Infrastructure\Exception\Abstract\ApplicationException;

class EntityNotFoundException extends ApplicationException
{
    private const TEMPLATE = 'Entity of type %s and %s: %s not found.';

    public readonly string $type;

    public readonly string $property;

    /**
     * @param class-string $type
     */
    public function __construct(
        string $type,
        public readonly string|Stringable $value,
        string $property = 'id',
    ) {
        $this->type = $this->getTypeShortName($type);
        $this->property = $property;

        parent::__construct(
            sprintf(self::TEMPLATE, $this->type, $this->property, (string) $this->value)
        );
    }

    public function getStatusCode(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}
