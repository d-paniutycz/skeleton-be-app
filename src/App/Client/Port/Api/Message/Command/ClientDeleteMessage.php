<?php

declare(strict_types=1);

namespace App\Client\Port\Api\Message\Command;

use App\Client\Domain\Value\ClientId;
use Sys\Application\Messenger\Message\CommandMessage;

readonly class ClientDeleteMessage implements CommandMessage
{
    public function __construct(
        public ClientId $clientId,
    ) {
    }
}
