<?php

namespace Sys\Test\Infrastructure\Port\Web\Resolver\Request\Strategy;

use Symfony\Component\HttpFoundation\Request;
use Sys\Infrastructure\Port\Web\Resolver\Request\Strategy\JsonContentResolverStrategy;
use Sys\Infrastructure\Test\UnitTest;

class JsonContentResolverStrategyUnitTest extends UnitTest
{
    public function testKeylessResolving(): void
    {
        // arrange
        $data = ['val', 'val'];

        $request = self::createStub(Request::class);
        $request->method('toArray')->willReturn($data);

        $subject = new JsonContentResolverStrategy();

        // act
        $result = $subject->resolve($request);

        // assert
        self::assertSame($data, $result);
    }

    public function testResolvingWithKey(): void
    {
        $data = [
            'key1' => 'val',
            'key2' => ['val', 'val'],
        ];

        $request = self::createStub(Request::class);
        $request->method('toArray')->willReturn($data);

        $subject = new JsonContentResolverStrategy('key2');

        // act
        $result = $subject->resolve($request);

        // assert
        self::assertSame($data['key2'], $result);
    }

    public function testResolvingWithUnknownKeyReturnsEmptyArray(): void
    {
        // arrange
        $data = ['key1' => 'val', 'key2' => 'val'];

        $request = self::createStub(Request::class);
        $request->method('toArray')->willReturn($data);

        $subject = new JsonContentResolverStrategy('key3');

        // act
        $result = $subject->resolve($request);

        // assert
        self::assertSame([], $result);
    }
}
