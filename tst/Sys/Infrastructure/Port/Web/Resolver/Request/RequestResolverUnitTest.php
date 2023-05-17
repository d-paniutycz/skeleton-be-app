<?php

namespace Sys\Test\Infrastructure\Port\Web\Resolver\Request;

use stdClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sys\Infrastructure\Component\Denormalizer\Class\ClassDenormalizer;
use Sys\Infrastructure\Port\Web\Resolver\Request\RequestResolver;
use Sys\Infrastructure\Port\Web\Resolver\Request\ResolvableRequest;
use Sys\Infrastructure\Port\Web\Resolver\Request\Strategy\RequestResolverStrategy;
use Sys\Infrastructure\Test\Type\UnitTest;

class RequestResolverUnitTest extends UnitTest
{
    private readonly RequestResolver $subject;

    private readonly ClassDenormalizer $denormalizer;

    private readonly ValidatorInterface $validator;

    protected function setUp(): void
    {
        $this->denormalizer = self::createStub(ClassDenormalizer::class);
        $this->validator = self::createStub(ValidatorInterface::class);

        $this->subject = new RequestResolver($this->denormalizer, $this->validator);
    }

    public function testResolverNotSupportingOtherTypes(): void
    {
        // arrange
        $request = self::createStub(Request::class);

        $arguments = self::createStub(ArgumentMetadata::class);
        $arguments->method('getType')->willReturn(stdClass::class);

        // act
        $result = iterator_to_array(
            $this->subject->resolve($request, $arguments)
        );

        // assert
        self::assertEmpty($result);
    }

    public function testResolverSupportingUlidValueType(): void
    {
        // arrange
        $strategy = self::createStub(RequestResolverStrategy::class);
        $strategy->method('resolve')->willReturn([]);

        $proxy = new class($strategy) implements ResolvableRequest {
            private static RequestResolverStrategy $strategy;

            public function __construct(RequestResolverStrategy $strategy)
            {
                self::$strategy = $strategy;
            }

            public static function getRequestResolver(): RequestResolverStrategy
            {
                return self::$strategy;
            }
        };

        $request = self::createStub(Request::class);

        $arguments = self::createStub(ArgumentMetadata::class);
        $arguments->method('getType')->willReturn(get_class($proxy));

        $this->denormalizer->method('denormalize')->willReturn($proxy);
        $this->validator->method('validate')->willReturn(
            new ConstraintViolationList()
        );

        // act
        $result = iterator_to_array(
            $this->subject->resolve($request, $arguments)
        );

        // assert
        self::assertIsArray($result);
        self::assertCount(1, $result);
        self::assertSame($proxy, $result[0]);
    }
}
