<?php

declare(strict_types=1);

namespace App\Client\Application\Model;

use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\Token\ClientTokenValue;

class ClientTokenDto
{
    public function __construct(
        public readonly ClientTokenValue $value,
        public readonly ClientId $clientId,
    ) {
    }
}
