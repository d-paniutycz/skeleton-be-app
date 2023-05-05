<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Port\Web\Resolver\Request;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionProperty;
use RuntimeException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Sys\Application\Exception\InputValidationFailedException;
use Sys\Infrastructure\Constraint\ConstraintViolationFactory;

readonly class ScalarPropertySetter
{
    public function __construct(
        private ConstraintViolationFactory $violationFactory,
    ) {
    }

    /**
     * @param array<string, mixed> $data
     * @param class-string $class
     */
    public function setProperties(array $data, string $class): object
    {
        try {
            $reflect = new ReflectionClass($class);

            $instance = $reflect->newInstanceWithoutConstructor();
        } catch (ReflectionException $exception) {
            $template = 'Class "%s" cannot be instantiated.';

            throw new RuntimeException(sprintf($template, $class), previous: $exception);
        }

        $violationList = new ConstraintViolationList();

        foreach ($reflect->getProperties() as $property) {
            $violation = $this->setProperty($instance, $property, $data);

            if (!is_null($violation)) {
                $violationList->add($violation);
            }
        }

        if ($violationList->count() > 0) {
            throw new InputValidationFailedException('Setter input validation failed', $violationList);
        }

        return $instance;
    }

    private function assertPropertyIsSafeToSet(ReflectionProperty $property, string $class): void
    {
        $propertyName = $property->getName();
        $propertyType = $property->getType();

        if (is_null($propertyType)) {
            $template = 'Property "%s" of class "%s" is missing type.';

            throw new InvalidArgumentException(sprintf($template, $propertyName, $class));
        }

        if (!$propertyType instanceof ReflectionNamedType) {
            $template = 'Property "%s" of class "%s" should have no unions or intersections.';

            throw new InvalidArgumentException(sprintf($template, $propertyName, $class));
        }

        if (!$propertyType->isBuiltin()) {
            $template = 'Property "%s" of class "%s" is not a builtin type.';

            throw new InvalidArgumentException(sprintf($template, $propertyName, $class));
        }
    }

    /**
     * @param array<string, mixed> $data
     */
    private function setProperty(object $instance, ReflectionProperty $property, array $data): ?ConstraintViolation
    {
        $this->assertPropertyIsSafeToSet($property, get_class($instance));

        /** @var ReflectionNamedType $propertyType */
        $propertyType = $property->getType();
        $propertyName = $property->getName();

        if (array_key_exists($propertyName, $data)) {
            /** @var array<string, mixed> $value */
            $value = $data[$propertyName];
            $propertyTypeName = $propertyType->getName();

            if ($this->isTypesCompatible($propertyTypeName, get_debug_type($value))) {
                $property->setValue($instance, $value);

                return null;
            }

            return $this->violationFactory->invalidTypeViolation($propertyName, $propertyTypeName, $value);
        }

        if ($propertyType->allowsNull()) {
            $property->setValue($instance);

            return null;
        }

        if ($property->hasDefaultValue()) {
            return null;
        }

        return $this->violationFactory->isNullViolation($propertyName);
    }

    private function isTypesCompatible(string $typeA, string $typeB): bool
    {
        if ($typeA === $typeB) {
            return true;
        }

        if ($typeA === 'mixed') {
            return true;
        }

        if ($typeA === 'iterable' && $typeB === 'array') {
            return true;
        }

        if ($typeA === 'float' && $typeB === 'integer') {
            return true;
        }

        return false;
    }
}
