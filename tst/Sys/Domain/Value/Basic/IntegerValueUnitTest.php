<?php

namespace Sys\Test\Domain\Value\Basic;

use PHPUnit\Framework\Attributes\DataProvider;
use Sys\Domain\Value\Basic\BooleanValue;
use Sys\Domain\Value\Basic\IntegerValue;
use Sys\Domain\Value\Basic\StringValue;
use Sys\Domain\Value\Basic\Valuable;
use Sys\Infrastructure\Test\Type\UnitTest;

class IntegerValueUnitTest extends UnitTest
{
    private readonly Valuable $subject;

    protected function setUp(): void
    {
        $this->subject = new class(1) extends IntegerValue {};
    }

    #[DataProvider('valuableProvider')]
    public function testEquality(Valuable $value, bool $expected): void
    {
        // assert
        self::assertEquals($expected, $this->subject->equals($value));
    }

    public function testUnpacking(): void
    {
        // assert
        self::assertSame(1, $this->subject->jsonSerialize());
    }

    public function testWhatYouSetIsWhatYouGet(): void
    {
        // assert
        self::assertSame(1, $this->subject->getValue());
    }

    public static function valuableProvider(): array
    {
        return [
            [new class(1) extends IntegerValue {}, true],
            [new class(-1) extends IntegerValue {}, false],
            [new class(true) extends BooleanValue {}, false],
            [new class('1') extends StringValue {}, false],
        ];
    }
}
