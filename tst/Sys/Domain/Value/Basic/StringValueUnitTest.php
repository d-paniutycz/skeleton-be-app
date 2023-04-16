<?php

namespace Sys\Test\Domain\Value\Basic;

use PHPUnit\Framework\Attributes\DataProvider;
use Sys\Domain\Value\Basic\BooleanValue;
use Sys\Domain\Value\Basic\IntegerValue;
use Sys\Domain\Value\Basic\StringValue;
use Sys\Domain\Value\Basic\Valuable;
use Sys\Infrastructure\Test\Type\UnitTest;

class StringValueUnitTest extends UnitTest
{
    private readonly Valuable $subject;

    protected function setUp(): void
    {
        $this->subject = new class ('true') extends StringValue {
        };
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
        self::assertSame('true', $this->subject->jsonSerialize());
    }

    public function testWhatYouSetIsWhatYouGet(): void
    {
        // assert
        self::assertSame('true', $this->subject->getValue());
    }

    public function testStringable(): void
    {
        // act
        $value = strval($this->subject);

        // assert
        self::assertSame('true', $value);
    }

    public static function valuableProvider(): array
    {
        return [
            [
                new class ('true') extends StringValue {
                },
                true,
            ],
            [
                new class ('1') extends StringValue {
                },
                false,
            ],
            [
                new class (1) extends IntegerValue {
                },
                false,
            ],
            [
                new class (true) extends BooleanValue {
                },
                false,
            ],
        ];
    }
}
