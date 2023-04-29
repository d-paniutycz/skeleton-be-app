<?php

declare(strict_types=1);

namespace App\Client\Infrastructure\Persistence;

use App\Client\Application\Dto\ClientDto;
use App\Client\Application\Repository\ClientReadRepository;
use App\Client\Domain\Client\ClientId;
use App\Client\Domain\Client\ClientName;
use Doctrine\DBAL\Connection;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineClientReadRepository implements ClientReadRepository
{
    private readonly Connection $connection;

    public function __construct(
        ManagerRegistry $managerRegistry,
    ) {
        $this->connection = $managerRegistry->getConnection('dms_pg1_pri');
    }

    private function recreateFromRow(array $row): ClientDto
    {
        return new ClientDto(
            new ClientId($row['client_id_value']),
            new ClientName($row['client_name_value']),
        );
    }

    public function find(ClientId $clientId): ?ClientDto
    {
        $builder = $this->connection->createQueryBuilder()
            ->select('c.*')
            ->from('client', 'c')
            ->where('c.client_id_value = :id')
            ->setParameter('id', $clientId);

        $result = $builder->fetchAssociative();

        return $result ? $this->recreateFromRow($result) : null;
    }
}
