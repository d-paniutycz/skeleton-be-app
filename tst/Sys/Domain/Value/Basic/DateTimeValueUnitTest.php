<?php

namespace Sys\Test\Domain\Value\Basic;

use DateTime;
use PHPUnit\Framework\Attributes\DataProvider;
use Sys\Application\Exception\Input\InputStringValueException;
use Sys\Domain\Value\Basic\DateTimeValue;
use Sys\Domain\Value\Basic\IntegerValue;
use Sys\Domain\Value\Basic\StringValue;
use Sys\Domain\Value\Basic\Valuable;
use Sys\Infrastructure\Test\Type\UnitTest;

class DateTimeValueUnitTest extends UnitTest
{
    #[DataProvider('valuableProvider')]
    public function testEquality(Valuable $value, bool $expected): void
    {
        // arrange
        $subject = new class ('2023-05-16 15:02') extends DateTimeValue {
        };

        // assert
        self::assertEquals($expected, $subject->equals($value));
    }

    public function testThrowingExceptionOnInvalidInput(): void
    {
        // assert
        self::expectException(InputStringValueException::class);

        // act
        new class ('not valid date') extends DateTimeValue {
        };
    }

    public function testUnpacking(): void
    {
        // arrange
        $subject = new class ($formatted = '2023-05-16T15:02:00.000Z') extends DateTimeValue {
        };

        // assert
        self::assertSame($formatted, $subject->jsonSerialize());
    }

    public function testReturnsImmutableOfSameValue(): void
    {
        // arrange
        $subject = new class ($dateTime = new DateTime()) extends DateTimeValue {
        };

        // assert
        self::assertNotSame($dateTime, $subject->getValue());
        self::assertEquals($dateTime, $subject->getValue());
    }

    public static function valuableProvider(): array
    {
        return [
            [
                new class ('2023-05-16T15:02:00.000Z') extends DateTimeValue {
                },
                true,
            ],
            [
                new class (new DateTime('2023-05-16 15:02')) extends DateTimeValue {
                },
                true,
            ],
            [
                new class ('2023-05-16T15:02:00.000Z') extends StringValue {
                },
                true,
            ],
            [
                new class (new DateTime()) extends DateTimeValue {
                },
                false,
            ],
            [
                new class ('2023-05-16 15:02') extends StringValue {
                },
                false,
            ],
            [
                new class (1684242120) extends IntegerValue {
                },
                false,
            ],
        ];
    }
}
