<?php

namespace Sys\Test\Domain\Value;

use Sys\Application\Exception\Input\InputStringValueException;
use Sys\Domain\Value\HashedSecretValue;
use Sys\Infrastructure\Test\Type\UnitTest;

class HashedSecretValueUnitTest extends UnitTest
{
    private static string $secretHash;
    private static string $secretText = 'text';

    public static function setUpBeforeClass(): void
    {
        self::$secretHash = password_hash(self::$secretText, PASSWORD_ARGON2ID);
    }

    public function testHashedSecretIsValid(): void
    {
        // arrange
        $proxy = new class (self::$secretHash) extends HashedSecretValue {
        };

        // act
        $subject = $proxy::hash(self::$secretText);

        // assert
        self::assertTrue(
            $subject->verify(self::$secretText)
        );
    }

    public function testThrowingExceptionOnInvalidInput(): void
    {
        // assert
        self::expectException(InputStringValueException::class);

        // act
        new class ('invalid hash') extends HashedSecretValue {
        };
    }
}
