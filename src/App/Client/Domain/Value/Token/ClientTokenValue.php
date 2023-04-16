<?php

declare(strict_types=1);

namespace App\Client\Domain\Value\Token;

use Sys\Domain\Value\Basic\StringValue;

class ClientTokenValue extends StringValue
{
    public static function generate(): self
    {
        return new self(
            bin2hex(
                random_bytes(64)
            )
        );
    }
}
