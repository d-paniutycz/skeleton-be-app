<?php

declare(strict_types=1);

namespace App\Client\Port\Api\Message\Command;

use App\Client\Domain\Client\ClientId;
use App\Client\Domain\Client\ClientName;
use Sys\Cqrs\Application\Message\CommandMessage;

class ClientCreateCommand implements CommandMessage
{
    public function __construct(
        public readonly ClientId $clientId,
        public readonly ClientName $clientName,
    ) {
    }
}
