<?php

declare(strict_types=1);

namespace App\Client\Port\Api;

use App\Client\Application\Model\ClientDto;
use App\Client\Domain\Value\ClientId;

interface ClientSecurity
{
    public function getClient(): ?ClientDto;

    public function getClientId(): ClientId;

    public function loginClient(ClientDto $clientDto): void;
}
