<?php

namespace Sys\Test\Infrastructure\Component\Serializer\Normalizer;

use RuntimeException;
use stdClass;
use Sys\Domain\Value\Basic\StringValue;
use Sys\Domain\Value\Basic\Valuable;
use Sys\Infrastructure\Component\Serializer\Normalizer\ValuableNormalizer;
use Sys\Infrastructure\Test\UnitTest;

class ValuableNormalizerUnitTest extends UnitTest
{
    private readonly ValuableNormalizer $subject;

    protected function setUp(): void
    {
        $this->subject = new ValuableNormalizer();
    }

    public function testValuableCanBeDenormalized(): void
    {
        // arrange
        $value = 'test';
        $proxy = new class($value) extends StringValue {};

        // act
        $result = $this->subject->denormalize($value, get_class($proxy));

        // assert
        self::assertInstanceOf(Valuable::class, $result);
        self::assertEquals($proxy, $result);
    }

    public function testThrowingExceptionWhenNotValuable(): void
    {
        // assert
        self::expectException(RuntimeException::class);

        // act
        $this->subject->denormalize('test', stdClass::class);
    }

    public function testValuablesAreSupported(): void
    {
        // arrange
        $proxy = self::createStub(Valuable::class);

        // assert
        self::assertTrue(
            $this->subject->supportsDenormalization('test', get_class($proxy))
        );
    }
}
