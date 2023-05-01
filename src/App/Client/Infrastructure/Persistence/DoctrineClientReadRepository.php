<?php

declare(strict_types=1);

namespace App\Client\Infrastructure\Persistence;

use App\Client\Application\Dto\ClientDto;
use App\Client\Application\Repository\ClientReadRepository;
use App\Client\Domain\Value\ClientEmail;
use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientPassword;
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
            new ClientId((string) $row['id']),
            new ClientEmail((string) $row['email']),
            new ClientPassword((string) $row['password']),
        );
    }

    public function find(ClientId $id): ?ClientDto
    {
        $builder = $this->connection->createQueryBuilder()
            ->select('c.*')
            ->from('client', 'c')
            ->where('c.id = :id')
            ->setParameter('id', $id);

        $result = $builder->fetchAssociative();

        return $result ? $this->recreateFromRow($result) : null;
    }
}
