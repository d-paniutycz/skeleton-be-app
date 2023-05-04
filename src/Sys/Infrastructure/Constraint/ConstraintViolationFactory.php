<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Constraint;

use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\ConstraintViolation;

class ConstraintViolationFactory
{
    public function invalidTypeViolation(
        string $propertyPath,
        string $type,
        mixed $invalidValue,
    ): ConstraintViolation {
        return new ConstraintViolation(
            "This value should be of type $type.",
            'This value should be of type {{ type }}.',
            ['{{ value }}' => $invalidValue, '{{ type }}' => $type],
            null,
            $propertyPath,
            $invalidValue,
            null,
            Type::INVALID_TYPE_ERROR,
        );
    }

    public function isNullViolation(
        string $propertyPath,
    ): ConstraintViolation {
        return new ConstraintViolation(
            'This value should not be null.',
            'This value should not be {{ value }}.',
            ['{{ value }}' => null],
            null,
            $propertyPath,
            null,
            null,
            NotNull::IS_NULL_ERROR
        );
    }
}
