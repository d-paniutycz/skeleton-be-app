<?php

declare(strict_types=1);

namespace App\Client\Port\Api\Message\Command;

use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\Token\ClientTokenValue;
use Sys\Application\Messenger\Message\CommandMessage;

readonly class ClientTokenCreateMessage implements CommandMessage
{
    public function __construct(
        public ClientTokenValue $tokenValue,
        public ClientId $clientId,
        public bool $remember,
    ) {
    }
}
