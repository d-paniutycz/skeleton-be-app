<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Port\Web\Resolver\Request;

use Generator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sys\Application\Exception\Input\InputValidationFailedException;
use Sys\Infrastructure\Component\Denormalizer\Class\ClassDenormalizer;

readonly class RequestResolver implements ValueResolverInterface
{
    public function __construct(
        private ClassDenormalizer $denormalizer,
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * @return Generator<int, ?ResolvableRequest>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $type = $argument->getType();
        if (is_null($type) || !is_subclass_of($type, ResolvableRequest::class)) {
            return null;
        }

        $data = $type::getRequestResolver()->resolve($request);

        /** @var ResolvableRequest $input */
        $input = $this->denormalizer->denormalize($data, $type);

        // @TODO: decouple, will allow to use validation groups in direct calls
        $violationList = $this->validator->validate($input);
        if ($violationList->count() > 0) {
            throw new InputValidationFailedException('Resolver data validation failed', $violationList);
        }

        yield $input;
    }
}
