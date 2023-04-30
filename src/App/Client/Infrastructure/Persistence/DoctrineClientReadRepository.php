<?php

declare(strict_types=1);

namespace App\Client\Infrastructure\Persistence;

use App\Client\Application\Dto\ClientDto;
use App\Client\Application\Repository\ClientReadRepository;
use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientName;
use Doctrine\DBAL\Connection;

readonly class DoctrineClientReadRepository implements ClientReadRepository
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    /**
     * @param array<string, mixed> $row
     */
    private function recreateFromRow(array $row): ClientDto
    {
        return new ClientDto(
            new ClientId((string) $row['client_id']),
            new ClientName((string) $row['client_name']),
        );
    }

    public function find(ClientId $clientId): ?ClientDto
    {
        $builder = $this->connection->createQueryBuilder()
            ->select('c.*')
            ->from('client', 'c')
            ->where('c.client_id = :clientId')
            ->setParameter('clientId', $clientId);

        $result = $builder->fetchAssociative();

        return $result ? $this->recreateFromRow($result) : null;
    }
}
