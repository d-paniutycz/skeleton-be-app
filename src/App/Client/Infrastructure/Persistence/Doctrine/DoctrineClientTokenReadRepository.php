<?php

declare(strict_types=1);

namespace App\Client\Infrastructure\Persistence\Doctrine;

use App\Client\Application\Model\ClientTokenDto;
use App\Client\Application\Repository\ClientTokenReadRepository;
use App\Client\Domain\Value\Token\ClientTokenValue;
use Doctrine\DBAL\Query\QueryBuilder;
use Sys\Infrastructure\Doctrine\Repository\AbstractReadRepository;

class DoctrineClientTokenReadRepository extends AbstractReadRepository implements ClientTokenReadRepository
{
    private function fetchRecreatedToken(QueryBuilder $builder): ?ClientTokenDto
    {
        $row = $builder->fetchAssociative();
        if (false === $row) {
            return null;
        }

        /** @var ClientTokenDto $dto */
        $dto = $this->serializer->denormalize($row, ClientTokenDto::class);

        return $dto;
    }

    public function find(ClientTokenValue $value): ?ClientTokenDto
    {
        $builder = $this->manager->getConnection()->createQueryBuilder()
            ->select('ct.*')
            ->from('client_token', 'ct')
            ->where('ct.value = :tokenValue')
            ->setParameter('tokenValue', $value);

        return $this->fetchRecreatedToken($builder);
    }
}
