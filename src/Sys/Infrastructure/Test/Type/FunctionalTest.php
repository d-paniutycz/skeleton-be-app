<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Test\Type;

use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Test\BrowserKitAssertionsTrait;
use Symfony\Component\BrowserKit\AbstractBrowser;
use Sys\Infrastructure\Test\Helper\TestRequestBuilder;

class FunctionalTest extends IntegrationTest
{
    use BrowserKitAssertionsTrait;

    private static ?AbstractBrowser $browserClient = null;

    protected function tearDown(): void
    {
        self::$browserClient = null;
        self::getClient(null);

        parent::tearDown();
    }

    protected function buildRequest(): TestRequestBuilder
    {
        if (is_null(self::$browserClient)) {
            /** @var AbstractBrowser $client */
            $client = self::getContainer()->get('test.client');

            self::$browserClient = self::getClient($client);

            if (is_null(self::$browserClient)) {
                throw new RuntimeException('Browser client could not be created');
            }
        }

        return new TestRequestBuilder(self::$browserClient);
    }
}
