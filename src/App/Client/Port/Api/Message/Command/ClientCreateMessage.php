<?php

declare(strict_types=1);

namespace App\Client\Port\Api\Message\Command;

use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientPassword;
use App\Client\Domain\Value\ClientUsername;
use Sys\Application\Messenger\Message\CommandMessage;
use Sys\Application\Messenger\Message\Flag\AsyncMessage;

readonly class ClientCreateMessage implements CommandMessage, AsyncMessage
{
    public function __construct(
        public ClientId $clientId,
        public ClientUsername $clientUsername,
        public ClientPassword $clientPassword,
    ) {
    }
}
