<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Resolver;

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
        $type = $argument->getType();
        if (is_null($type) || !is_subclass_of($type, UniqueStringIdValue::class)) {
            return [];
        }

        /** @var ?string $value */
        $value = $request->attributes->get(
            $argument->getName()
        );

        return is_string($value) ? [new $type($value)] : [];
    }
}
