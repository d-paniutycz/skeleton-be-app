<?php

declare(strict_types=1);

namespace App\Client\Domain\Repository;

use App\Client\Domain\Client;
use App\Client\Domain\Value\ClientId;

interface ClientWriteRepository
{
    public function persist(Client $client): void;

    public function find(ClientId $id): ?Client;
}
