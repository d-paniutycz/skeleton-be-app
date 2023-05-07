<?php

declare(strict_types=1);

namespace App\Client\Application\Repository;

use App\Client\Application\Dto\ClientDto;
use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientUsername;

interface ClientReadRepository
{
    public function find(ClientId $clientId): ?ClientDto;

    public function findByUsername(ClientUsername $clientUsername): ?ClientDto;
}
