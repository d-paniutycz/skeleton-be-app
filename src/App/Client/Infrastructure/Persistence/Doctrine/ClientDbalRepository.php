<?php

declare(strict_types=1);

namespace App\Client\Infrastructure\Persistence\Doctrine;

use App\Client\Application\Dto\ClientDto;
use App\Client\Application\Repository\ClientReadRepository;
use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientPassword;
use App\Client\Domain\Value\ClientUsername;
use Doctrine\DBAL\Query\QueryBuilder;
use Sys\Infrastructure\Doctrine\Repository\DbalRepository;

class ClientDbalRepository extends DbalRepository implements ClientReadRepository
{
    /**
     * @param array<string, mixed> $row
     */
    private function recreateFromRow(array $row): ClientDto
    {
        return new ClientDto(
            new ClientId((string) $row['id']),
            new ClientUsername((string) $row['username']),
            new ClientPassword((string) $row['password']),
        );
    }

    private function getClientQueryBuilder(): QueryBuilder
    {
        return $this->connection->createQueryBuilder()
            ->select('c.*')
            ->from('client', 'c');
    }

    public function find(ClientId $clientId): ?ClientDto
    {
        $builder = $this->getClientQueryBuilder()
            ->where('c.id = :id')
            ->setParameter('id', $clientId);

        // @TODO: try additional abstraction with decorator for fetchAll
        $result = $builder->fetchAssociative();

        // @TODO: try one of the normalizers instead
        return $result ? $this->recreateFromRow($result) : null;
    }

    public function findByUsername(ClientUsername $clientUsername): ?ClientDto
    {
        $builder = $this->getClientQueryBuilder()
            ->where('c.username = :username')
            ->setParameter('username', $clientUsername);

        $result = $builder->fetchAssociative();

        return $result ? $this->recreateFromRow($result) : null;
    }
}
