<?php

declare(strict_types=1);

namespace Sys\Application\Security;

use App\Client\Application\Model\ClientDto;
use App\Client\Domain\Value\ClientId;

interface SystemSecurity
{
    public function getClient(): ?ClientDto;

    public function getClientId(): ClientId;

    public function loginClient(ClientDto $clientDto): void;
}
