<?php

declare(strict_types=1);

namespace App\Client\Infrastructure\Security;

use App\Client\Application\Exception\ClientNotAuthenticatedException;
use App\Client\Application\Model\ClientDto;
use App\Client\Domain\Value\ClientId;
use App\Client\Port\Api\ClientSecurity;
use Symfony\Bundle\SecurityBundle\Security;

readonly class SecurityAdapter implements ClientSecurity
{
    public function __construct(
        private Security $security,
    ) {
    }

    public function getClient(): ?ClientDto
    {
        /** @var ?ClientDto $client */
        $client = $this->security->getUser();

        return $client;
    }

    public function getClientId(): ClientId
    {
        $client = $this->getClient();
        if (is_null($client)) {
            throw new ClientNotAuthenticatedException();
        }

        return $client->id;
    }

    public function loginClient(ClientDto $clientDto): void
    {
        $this->security->login($clientDto);
    }
}
