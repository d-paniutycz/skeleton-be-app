<?php

namespace App\Test\Client\Application\Handler\Command;

use App\Client\Application\Handler\Command\ClientCreateHandler;
use App\Client\Domain\Client;
use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientPassword;
use App\Client\Domain\Value\ClientUsername;
use App\Client\Port\Api\Message\Command\ClientCreateMessage;
use Sys\Infrastructure\Test\Type\IntegrationTest;

class ClientCreateHandlerIntegrationTest extends IntegrationTest
{
    public function testDupa(): void
    {
        // arrange
        $message = new ClientCreateMessage(
            $clientId = ClientId::generate(),
            new ClientUsername('test'),
            ClientPassword::hash('test'),
        );

        // act
        $this->getService(ClientCreateHandler::class)($message);

        // assert
        self::assertNotNull(
            $this->entityManager->find(Client::class, $clientId)
        );
    }
}
