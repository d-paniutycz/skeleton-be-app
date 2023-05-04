<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Port\Web\Resolver\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Messenger\Exception\ValidationFailedException;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly PropertySetter $propertySetter,
        private readonly ValidatorInterface $validator,
    ) {
    }

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

        $input = $this->propertySetter->setProperties($data, $class);

        $violationList = $this->validator->validate($input);
        if ($violationList->count() > 0) {
            throw new ValidationFailedException($input, $violationList);
        }

        return [$input];
    }
}
