<?php

declare(strict_types=1);

namespace App\Client\Infrastructure\Persistence\Doctrine;

use App\Client\Application\Model\ClientDto;
use App\Client\Application\Repository\ClientReadRepository;
use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientUsername;
use Doctrine\DBAL\Query\QueryBuilder;
use Sys\Infrastructure\Doctrine\Repository\AbstractReadRepository;

class DoctrineClientReadRepository extends AbstractReadRepository implements ClientReadRepository
{
    private function fetchRecreatedClient(QueryBuilder $builder): ?ClientDto
    {
        $row = $builder->fetchAssociative();
        if (false === $row) {
            return null;
        }

        /** @var ClientDto $dto */
        $dto = $this->serializer->denormalize($row, ClientDto::class);

        return $dto;
    }

    private function getClientBuilder(): QueryBuilder
    {
        return $this->manager->getConnection()->createQueryBuilder()
            ->select('c.*')
            ->from('client', 'c');
    }

    public function find(ClientId $clientId): ?ClientDto
    {
        $builder = $this->getClientBuilder()
            ->where('c.id = :id')
            ->setParameter('id', $clientId);

        return $this->fetchRecreatedClient($builder);
    }

    public function findByUsername(ClientUsername $clientUsername): ?ClientDto
    {
        $builder = $this->getClientBuilder()
            ->where('c.username = :username')
            ->setParameter('username', $clientUsername);

        return $this->fetchRecreatedClient($builder);
    }
}
