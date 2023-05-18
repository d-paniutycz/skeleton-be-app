<?php

declare(strict_types=1);

namespace App\Test\Client\Test;

use App\Client\Domain\Client;
use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientPassword;
use App\Client\Domain\Value\ClientUsername;
use App\Client\Domain\Value\Token\ClientTokenValue;
use Doctrine\ORM\EntityManagerInterface;
use Sys\Domain\Value\Role;

class ClientFixtureLoader
{
    // @TODO: Pajet my son you have failed, use the password generator interface per env next time
    private string $password = '$argon2id$v=19$m=65536,t=4,p=1$dnBaR3NUWDh5TDhDNWhvSA$X9F6iWvK32OVvSEFPXZDJ8NoHhqgSyTbABf8lO0egRU';

    public function __construct(
        private readonly EntityManagerInterface $manager,
    ) {
    }

    public function load(
        ClientId $clientId = null,
        ClientUsername $clientUsername = null,
        ClientPassword $clientPassword = null,
        Role $role = null,
        ClientTokenValue $tokenValue = null,
    ): ClientId {
        $clientId = $clientId ?? ClientId::generate();
        $clientUsername = $clientUsername ?? new ClientUsername($clientId->getValue());
        $clientPassword = $clientPassword ?? new ClientPassword($this->password);

        $client = new Client($clientId, $clientUsername, $clientPassword);

        if (!is_null($role)) {
            $client->setRole($role);
        }

        if (!is_null($tokenValue)) {
            $client->createToken($tokenValue, false);
        }

        $this->manager->persist($client);
        $this->manager->flush();

        return $clientId;
    }
}
