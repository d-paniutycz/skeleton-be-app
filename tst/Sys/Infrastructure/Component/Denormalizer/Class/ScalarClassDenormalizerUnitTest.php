<?php

namespace Sys\Test\Infrastructure\Component\Denormalizer\Class;

use Generator;
use InvalidArgumentException;
use IteratorAggregate;
use PHPUnit\Framework\Attributes\DataProvider;
use stdClass;
use Sys\Infrastructure\Component\Denormalizer\Class\ScalarClassDenormalizer;
use Sys\Infrastructure\Test\Type\UnitTest;

class ScalarClassDenormalizerUnitTest extends UnitTest
{
    private readonly ScalarClassDenormalizer $subject;

    protected function setUp(): void
    {
        $this->subject = new ScalarClassDenormalizer();
    }

    public function testDenormalizingData(): void
    {
        // arrange
        $data = [
            'integer' => 1,
            'string' => 'A',
            'array' => [1, 'A'],
            'bool' => true,
            'float' => 1.1,
            'mixed' => new stdClass(),
        ];

        $expectedData = $data + ['default' => 'default', 'nullable' => null];

        $proxy = new class {
            public int $integer;
            public ?int $nullable;
            public string $string;
            public string $default = 'default';
            public iterable $array;
            public bool $bool;
            public float $float;
            public mixed $mixed;
        };

        // act
        $result = $this->subject->denormalize($data, get_class($proxy));

        // assert
        self::assertIsObject($result);
        self::assertEquals($expectedData, get_object_vars($result));
    }

    #[DataProvider('wrongTypedProxyProvider')]
    public function testExceptionThrownOnWrongType(object $proxy): void
    {
        // assert
        self::expectException(InvalidArgumentException::class);

        // act
        $this->subject->denormalize([], get_class($proxy));
    }

    public static function wrongTypedProxyProvider(): array
    {
        return [
            [
                new class {
                    public int|string $value; // union
                }
            ],
            [
                new class {
                    public IteratorAggregate&Generator $value; // intersection
                }
            ],
            [
                new class {
                    public $value; // missing type
                }
            ],
            [
                new class {
                    public stdClass $value; // not builtin
                }
            ],
        ];
    }
}
