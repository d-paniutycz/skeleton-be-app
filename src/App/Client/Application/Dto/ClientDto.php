<?php

declare(strict_types=1);

namespace App\Client\Application\Dto;

use App\Client\Domain\Client\ClientId;
use App\Client\Domain\Client\ClientName;

readonly class ClientDto
{
    public function __construct(
        public ClientId $clientId,
        public ClientName $clientName,
    ) {
    }
}