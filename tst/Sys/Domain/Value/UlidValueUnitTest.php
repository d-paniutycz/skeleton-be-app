<?php

namespace Sys\Test\Domain\Value;

use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\Uid\Ulid;
use Sys\Application\Exception\Input\InputStringValueException;
use Sys\Domain\Value\UlidValue;
use Sys\Infrastructure\Test\UnitTest;

class UlidValueUnitTest extends UnitTest
{
    #[DataProvider('invalidInputProvider')]
    public function testThrowingExceptionOnInvalidInput(string $input): void
    {
        // assert
        self::expectException(InputStringValueException::class);

        // act
        new class($input) extends UlidValue {};
    }

    public function testGeneratedUlidIsValid(): void
    {
        // arrange
        $proxy = new class(Ulid::generate()) extends UlidValue {};

        // act
        $subject = $proxy::generate();

        // assert
        self::assertTrue(
            Ulid::isValid(
                $subject->getValue()
            )
        );
    }

    public static function invalidInputProvider(): array
    {
        return [
            ['01H0J6HA7HXCRCMVW5QBR77PQO'], // letter O is invalid
            ['01H0J6HA7HXCRCMVW5QBR77PQ'], // too short
            ['01H0J6HA7HXCRCMVW5QBR77PQC1'], // too long
            ['81H0J6HA7HXCRCMVW5QBR77PQC'], // first number is > 7
        ];
    }
}
