<?php

declare(strict_types=1);

namespace App\Client\Application\Repository;

use App\Client\Application\Dto\ClientDto;
use App\Client\Domain\Client\ClientId;

interface ClientReadRepository
{
    public function find(ClientId $clientId): ?ClientDto;
}
