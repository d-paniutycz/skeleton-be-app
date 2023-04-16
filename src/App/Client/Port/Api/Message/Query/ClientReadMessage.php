<?php

declare(strict_types=1);

namespace App\Client\Port\Api\Message\Query;

use App\Client\Domain\Value\ClientId;
use Sys\Application\Messenger\Message\QueryMessage;

readonly class ClientReadMessage implements QueryMessage
{
    public function __construct(
        public ClientId $clientId,
    ) {
    }
}
