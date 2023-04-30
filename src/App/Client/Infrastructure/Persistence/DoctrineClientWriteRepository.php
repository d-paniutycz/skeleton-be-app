<?php

declare(strict_types=1);

namespace App\Client\Infrastructure\Persistence;

use App\Client\Domain\Client;
use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Repository\ClientWriteRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManagerInterface;

readonly class DoctrineClientWriteRepository implements ClientWriteRepository
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function persist(Client $client): void
    {
        $this->entityManager->persist($client);
    }

    public function find(ClientId $clientId): ?Client
    {
        return $this->entityManager
            ->getRepository(Client::class)
            ->find($clientId, LockMode::PESSIMISTIC_READ);
    }
}
