<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Constraint;

use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationInterface;

class ConstraintViolationFactory
{
    public function typeViolation(string $property, string $type, string $invalidType): ConstraintViolationInterface
    {
        return new ConstraintViolation(
            'This value should be of type {{ type }}.',
            'This value should be of type {{ type }}.',
            ['{{ value }}' => $invalidType, '{{ type }}' => $type],
            null,
            $property,
            $invalidType,
            null,
            Type::INVALID_TYPE_ERROR,
        );
    }

    public function isNullViolation(string $property): ConstraintViolationInterface
    {
        return new ConstraintViolation(
            'This value should not be null.',
            'This value should not be {{ value }}.',
            ['{{ value }}' => null],
            null,
            $property,
            null,
            null,
            NotNull::IS_NULL_ERROR
        );
    }
}
