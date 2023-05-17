<?php

namespace Sys\Test\Infrastructure\Exception\Problem;

use Sys\Infrastructure\Exception\Abstract\ApplicationException;
use Sys\Infrastructure\Exception\Problem\ApiProblemExceptionMapper;
use Sys\Infrastructure\Test\UnitTest;

class ApiProblemExceptionMapperUnitTest extends UnitTest
{
    private readonly ApiProblemExceptionMapper $subject;

    protected function setUp(): void
    {
        $this->subject = new ApiProblemExceptionMapper();
    }

    public function testSanitizingAdditionalParameters(): void
    {
        // arrange
        $exception = new class extends ApplicationException {
            public string $secret = 'secret';
            public string $public = 'public';
            private string $private = 'private';
        };

        // act
        $result = $this->subject->map($exception)->getAdditional();

        // assert
        self::assertIsArray($result);
        self::assertCount(1, $result);
        self::assertArrayHasKey('public', $result);
    }
}
