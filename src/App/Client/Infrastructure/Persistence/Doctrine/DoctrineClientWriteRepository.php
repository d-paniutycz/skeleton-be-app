<?php

declare(strict_types=1);

namespace App\Client\Infrastructure\Persistence\Doctrine;

use App\Client\Domain\Client;
use App\Client\Domain\Repository\ClientWriteRepository;
use App\Client\Domain\Value\ClientId;
use Doctrine\DBAL\LockMode;
use Sys\Infrastructure\Doctrine\Repository\AbstractWriteRepository;

class DoctrineClientWriteRepository extends AbstractWriteRepository implements ClientWriteRepository
{
    public function find(ClientId $clientId): ?Client
    {
        return $this->manager
            ->getRepository(Client::class)
            ->find($clientId, LockMode::PESSIMISTIC_READ);
    }

    public function findBy(array $criteria): ?Client
    {
        return $this->manager
            ->getRepository(Client::class)
            ->findOneBy($criteria);
    }
}
