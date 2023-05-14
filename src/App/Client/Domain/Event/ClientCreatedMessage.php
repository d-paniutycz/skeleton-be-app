<?php

declare(strict_types=1);

namespace App\Client\Domain\Event;

use App\Client\Domain\Value\ClientId;
use Sys\Application\Messenger\Message\EventMessage;

readonly class ClientCreatedMessage implements EventMessage
{
    public function __construct(
        public ClientId $clientId,
    ) {
    }
}
