<?php

declare(strict_types=1);

namespace App\Client\Port\Api\Message\Command;

use App\Client\Domain\Value\ClientUsername;
use Sys\Application\Messenger\Message\CommandMessage;

readonly class ClientLoginMessage implements CommandMessage
{
    public function __construct(
        public ClientUsername $username,
        public string $password,
    ) {
    }
}
