<?php

namespace Sys\Test\Domain\Value;

use PHPUnit\Framework\Attributes\DataProvider;
use Sys\Domain\Value\Basic\StringValue;
use Sys\Domain\Value\Basic\Valuable;
use Sys\Domain\Value\Role;
use Sys\Infrastructure\Test\Type\UnitTest;

class RoleUnitTest extends UnitTest
{
    private Role $subject = Role::REGULAR;

    #[DataProvider('valuableProvider')]
    public function testEquality(Valuable $value, bool $expected): void
    {
        // assert
        self::assertEquals($expected, $this->subject->equals($value));
    }

    public function testUnpacking(): void
    {
        // assert
        self::assertSame(Role::REGULAR->getValue(), $this->subject->jsonSerialize());
    }

    public static function valuableProvider(): array
    {
        return [
            [new class(Role::REGULAR->getValue()) extends StringValue {}, true],
            [Role::REGULAR, true],
            [Role::MASTER, false],
        ];
    }
}
