<?php

declare(strict_types=1);

namespace Sys\Application\Security;

use App\Client\Application\Dto\ClientDto;

interface SystemSecurity
{
    public function getClient(): ?ClientDto;
}
