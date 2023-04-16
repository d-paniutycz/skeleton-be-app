<?php

declare(strict_types=1);

namespace App\Client\Domain\Repository;

use App\Client\Domain\Client;
use App\Client\Domain\Value\ClientId;
use Sys\Infrastructure\Doctrine\Repository\WriteRepository;

interface ClientWriteRepository extends WriteRepository
{
    public function find(ClientId $clientId): ?Client;

    /**
     * @param array<string, mixed> $criteria
     */
    public function findBy(array $criteria): ?Client;
}
