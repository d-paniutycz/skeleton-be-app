<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Port\Web\Resolver\Value;

use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Sys\Domain\Value\UlidValue;

class UlidValueResolver implements ValueResolverInterface
{
    /**
     * @return Generator<int, ?UlidValue>
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

        yield is_string($value) ? new $class($value) : null;
    }
}
