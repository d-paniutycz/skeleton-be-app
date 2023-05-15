<?php

declare(strict_types=1);

namespace App\Test;

use PHPUnit\Framework\TestCase;

class DupaTest extends TestCase
{
    public function testDupa(): void
    {
        self::assertEquals('dupa', 'dupa');
    }
}
