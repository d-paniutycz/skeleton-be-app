<?php

declare(strict_types=1);

namespace App\Client\Port\Api\Message\Query;

use App\Client\Domain\Client\ClientId;
use Sys\Cqrs\Application\Message\QueryMessage;

class ClientReadQuery implements QueryMessage
{
    public function __construct(
        public readonly ClientId $clientId,
    ) {
    }
}
