<?php

namespace Sys\Test\Infrastructure\Port\Web\Resolver\Value;

use stdClass;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Uid\Ulid;
use Sys\Domain\Value\UlidValue;
use Sys\Infrastructure\Port\Web\Resolver\Value\UlidValueResolver;
use Sys\Infrastructure\Test\Type\UnitTest;

class UlidValueResolverUnitTest extends UnitTest
{
    private readonly UlidValueResolver $subject;

    protected function setUp(): void
    {
        $this->subject = new UlidValueResolver();
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
        $ulid = Ulid::generate();

        $proxy = new class($ulid) extends UlidValue {};

        $attributes = self::createStub(ParameterBag::class);
        $attributes->method('get')->willReturn($ulid);

        $request = self::createStub(Request::class);
        $request->attributes = $attributes;

        $arguments = self::createStub(ArgumentMetadata::class);
        $arguments->method('getType')->willReturn(get_class($proxy));
        $arguments->method('getName')->willReturn('ulid');

        // act
        $result = iterator_to_array(
            $this->subject->resolve($request, $arguments)
        );

        // assert
        self::assertIsArray($result);
        self::assertCount(1, $result);
        self::assertInstanceOf(UlidValue::class, $result[0]);
        self::assertEquals($ulid, $result[0]->getValue());
    }
}
