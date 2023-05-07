<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Component\Denormalizer\Class;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionProperty;
use RuntimeException;
use Sys\Application\Exception\Input\InputPropertyTypeException;

class ScalarClassDenormalizer implements ClassDenormalizer
{
    public function denormalize(array $data, string $type): object
    {
        try {
            $class = new ReflectionClass($type);
            $instance = $class->newInstanceWithoutConstructor();
        } catch (ReflectionException $exception) {
            $template = 'Class "%s" cannot be instantiated.';

            throw new RuntimeException(sprintf($template, $type), previous: $exception);
        }

        return $this->setProperties($data, $class, $instance);
    }

    /**
     * @param array<array-key, mixed> $data
     */
    private function setProperties(array $data, ReflectionClass $class, object $instance): object
    {
        foreach ($class->getProperties() as $property) {
            /** @var mixed $value */
            $value = $this->getPropertyValue($data, $property);

            if (!$this->isTypesValid($property, $value)) {
                $propertyTypeName = $property->getType() instanceof ReflectionNamedType
                    ? $property->getType()->getName() : 'missing';

                throw new InputPropertyTypeException($property->getName(), $propertyTypeName, get_debug_type($value));
            }

            $property->setValue($instance, $value);
        }

        return $instance;
    }

    /**
     * @param array<array-key, mixed> $data
     */
    private function getPropertyValue(array $data, ReflectionProperty $property): mixed
    {
        $propertyName = $property->getName();
        if (array_key_exists($propertyName, $data)) {
            return $data[$propertyName];
        }

        return $property->hasDefaultValue() ? $property->getDefaultValue() : null;
    }

    private function isTypesValid(ReflectionProperty $property, mixed $value): bool
    {
        $propertyName = $property->getName();
        $propertyType = $property->getType();

        if (is_null($propertyType)) {
            $template = 'Property "%s" of class "%s" is missing type.';

            throw new InvalidArgumentException(sprintf($template, $propertyName, $property->class));
        }

        if (!$propertyType instanceof ReflectionNamedType) {
            $template = 'Property "%s" of class "%s" should have no unions or intersections.';

            throw new InvalidArgumentException(sprintf($template, $propertyName, $property->class));
        }

        if (!$propertyType->isBuiltin()) {
            $template = 'Property "%s" of class "%s" is not a builtin type.';

            throw new InvalidArgumentException(sprintf($template, $propertyName, $property->class));
        }

        return $this->isTypeAllowingValue($propertyType, $value);
    }

    private function isTypeAllowingValue(ReflectionNamedType $type, mixed $value): bool
    {
        if (is_null($value) && $type->allowsNull()) {
            return true;
        }

        $valueTypeName = get_debug_type($value);
        if ($this->isTypeAllowingType($type->getName(), $valueTypeName)) {
            return true;
        }

        return false;
    }

    private function isTypeAllowingType(string $typeA, string $typeB): bool
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
