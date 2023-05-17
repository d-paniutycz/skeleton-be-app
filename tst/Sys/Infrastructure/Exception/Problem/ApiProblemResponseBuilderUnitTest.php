<?php

namespace Sys\Test\Infrastructure\Exception\Problem;

use Sys\Infrastructure\Component\Serializer\PublicPropertySerializer;
use Sys\Infrastructure\Exception\Abstract\ApplicationException;
use Sys\Infrastructure\Exception\Problem\ApiProblem;
use Sys\Infrastructure\Exception\Problem\ApiProblemExceptionMapper;
use Sys\Infrastructure\Exception\Problem\ApiProblemResponseBuilder;
use Sys\Infrastructure\Test\Type\UnitTest;

class ApiProblemResponseBuilderUnitTest extends UnitTest
{
    private readonly ApiProblemResponseBuilder $subject;

    protected function setUp(): void
    {
        $this->subject = new ApiProblemResponseBuilder(
            new PublicPropertySerializer(),
            new ApiProblemExceptionMapper(),
        );
    }

    public function testResponseStatusCodeIsMatchingApiProblem(): void
    {
        // arrange
        $statusCode = 404;
        $apiProblem = new ApiProblem('about:blank', 'about:blank', 'about:blank', 404);

        // act
        $result = $this->subject->build($apiProblem);

        // assert
        self::assertSame($statusCode, $result->getStatusCode());
    }

    public function testResponseStatusCodeIsMatchingHttpException(): void
    {
        // arrange
        $statusCode = 404;

        $exception = new class($statusCode) extends ApplicationException {
            public function __construct(private readonly int $statusCode)
            {
            }

            public function getStatusCode(): int
            {
                return $this->statusCode;
            }
        };

        // act
        $result = $this->subject->buildFromException($exception);

        // assert
        self::assertSame($statusCode, $result->getStatusCode());
    }
}
