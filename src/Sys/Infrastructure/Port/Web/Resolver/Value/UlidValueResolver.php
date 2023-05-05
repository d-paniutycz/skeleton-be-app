<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Port\Web\Resolver\Value;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Sys\Domain\Value\UlidValue;

class UlidValueResolver implements ValueResolverInterface
{
    /**
     * @return UlidValue[]
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $class = $argument->getType();
        if (is_null($class) || !is_subclass_of($class, UlidValue::class)) {
            return [];
        }

        /** @var ?string $value */
        $value = $request->attributes->get(
            $argument->getName()
        );

        // @TODO: check if can be yielded
        return is_string($value) ? [new $class($value)] : [];
    }
}
