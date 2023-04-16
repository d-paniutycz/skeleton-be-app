<?php

declare(strict_types=1);

namespace App\Client\Port\Api\Message\Query;

use App\Client\Domain\Value\Token\ClientTokenValue;
use Sys\Application\Messenger\Message\QueryMessage;

class ClientTokenReadMessage implements QueryMessage
{
    public function __construct(
        public ClientTokenValue $tokenValue,
    ) {
    }
}
