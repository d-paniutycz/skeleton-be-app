<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Port\Web\Resolver\Value;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Sys\Domain\Value\UniqueStringIdValue;

class UniqueStringIdValueResolver implements ValueResolverInterface
{
    /**
     * @return UniqueStringIdValue[]
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $class = $argument->getType();
        if (is_null($class) || !is_subclass_of($class, UniqueStringIdValue::class)) {
            return [];
        }

        /** @var ?string $value */
        $value = $request->attributes->get(
            $argument->getName()
        );

        return is_string($value) ? [new $class($value)] : [];
    }
}
