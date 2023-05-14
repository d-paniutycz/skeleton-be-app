<?php

declare(strict_types=1);

namespace App\Client\Application\Repository;

use App\Client\Application\Model\ClientDto;
use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientUsername;
use Sys\Infrastructure\Doctrine\Repository\ReadRepository;

interface ClientReadRepository extends ReadRepository
{
    public function find(ClientId $clientId): ?ClientDto;

    public function findByUsername(ClientUsername $clientUsername): ?ClientDto;
}
