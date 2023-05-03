<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Port\Web\Resolver\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;

class RequestResolver implements ValueResolverInterface
{
    /**
     * @return Resolvable[]
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $class = $argument->getType();
        if (is_null($class) || !is_subclass_of($class, Resolvable::class)) {
            return [];
        }

        $data = $class::getStrategy()->resolve($request);

        $normalizer = new PropertyNormalizer();

        /** @var Resolvable $input */
        $input = $normalizer->denormalize($data, $class);

        return [$input];
    }
}
