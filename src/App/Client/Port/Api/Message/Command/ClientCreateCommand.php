<?php

declare(strict_types=1);

namespace App\Client\Port\Api\Message\Command;

use App\Client\Domain\Value\ClientEmail;
use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientPassword;
use Sys\Application\Messenger\Message\CommandMessage;

readonly class ClientCreateCommand implements CommandMessage
{
    public function __construct(
        public ClientId $id,
        public ClientEmail $email,
        public ClientPassword $password,
    ) {
    }
}
