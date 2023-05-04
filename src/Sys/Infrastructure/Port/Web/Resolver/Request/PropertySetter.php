<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Port\Web\Resolver\Request;

use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionType;
use ReflectionUnionType;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Sys\Infrastructure\Constraint\ConstraintViolationFactory;

class PropertySetter
{
    public function __construct(
        private readonly ConstraintViolationFactory $violationFactory,
    ) {
    }

    /**
     * @param array $data
     * @param class-string $class
     */
    public function setProperties(array $data, string $class): object
    {
        $reflect = new ReflectionClass($class);
        $object = $reflect->newInstanceWithoutConstructor();

        $violationList = new ConstraintViolationList();

        foreach ($reflect->getProperties() as $property) {
            $violation = $this->setProperty($object, $property, $data);

            if (!is_null($violation)) {
                $violationList->add($violation);
            }
        }

        if ($violationList->count() > 0) {
            throw new ValidationFailedException($object, $violationList);
        }

        return $object;
    }

    private function setProperty(object $object, ReflectionProperty $property, array $data): ?ConstraintViolationInterface
    {
        $propertyName = $property->getName();
        $propertyType = $property->getType();

        if (array_key_exists($propertyName, $data) || $propertyType->allowsNull()) {
            $value = $data[$propertyName] ?? null;
            $valueType = get_debug_type($value);

            if ($this->isTypeAllowingType($propertyType, $valueType)) {
                $property->setValue($object, $value);
            } else {
                $violation = $this->violationFactory->typeViolation($propertyName, 'to mialo byc', $valueType);
            }
        } else {
            if (!$property->hasDefaultValue()) {
                $violation = $this->violationFactory->isNullViolation($propertyName);
            }
        }

        return $violation ?? null;
    }

    private function isTypeAllowingType(ReflectionType $propertyType, string $valueType): bool
    {
        if ('null' === $valueType) {
            return $propertyType->allowsNull();
        }

        if ($propertyType instanceof ReflectionNamedType) {
            return $this->isTypesCompatible($propertyType->getName(), $valueType);
        }

        if ($propertyType instanceof ReflectionUnionType) {
            return $this->isAnyOfTypesCompatible($propertyType->getTypes(), $valueType);
        }

        if ($propertyType instanceof ReflectionIntersectionType) {
            return $this->isAllOfTypesCompatible($propertyType->getTypes(), $valueType);
        }

        return false;
    }

    /**
     * @param ReflectionNamedType[] $propertyTypes
     */
    private function isAnyOfTypesCompatible(array $propertyTypes, string $valueType): bool
    {
        foreach ($propertyTypes as $propertyType) {
            if ($this->isTypesCompatible($propertyType->getName(), $valueType)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param ReflectionNamedType[] $propertyTypes
     */
    private function isAllOfTypesCompatible(array $propertyTypes, string $valueType): bool
    {
        foreach ($propertyTypes as $propertyType) {
            if (!$this->isTypesCompatible($propertyType->getName(), $valueType)) {
                return false;
            }
        }

        return true;
    }

    private function isTypesCompatible(string $typeA, string $typeB): bool
    {
        if ($typeA === $typeB) {
            return true;
        }

        if ($typeA === 'mixed') {
            return true;
        }

        if ($typeA === 'float' && $typeB === 'integer') {
            return true;
        }

        return false;
    }
}
