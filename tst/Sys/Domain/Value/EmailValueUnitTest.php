<?php

namespace Sys\Test\Domain\Value;

use PHPUnit\Framework\Attributes\DataProvider;
use Sys\Application\Exception\Input\InputStringValueException;
use Sys\Domain\Value\EmailValue;
use Sys\Infrastructure\Test\UnitTest;

class EmailValueUnitTest extends UnitTest
{
    #[DataProvider('invalidInputProvider')]
    public function testThrowingExceptionOnInvalidInput(string $input): void
    {
        // assert
        self::expectException(InputStringValueException::class);

        // act
        new class($input) extends EmailValue {};
    }

    public function testValueCanBeCreatedFromValidInput(): void
    {
        // act
        new class('email@test.com') extends EmailValue {};

        // assert
        self::assertTrue(true);
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['dobuble..special@test.com'],
            ['domain.extension@missing'],
            ['missing_at_test.com'],
            ['@missing.com'],
            ['dash@-start.com'],
        ];
    }
}
