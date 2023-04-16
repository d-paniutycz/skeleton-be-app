<?php

namespace App\Test\Client\Port\Web\Api;

use App\Client\Domain\Value\ClientPassword;
use App\Client\Domain\Value\ClientUsername;
use App\Test\Client\Test\ClientFixtureLoader;
use Symfony\Component\HttpFoundation\Response;
use Sys\Domain\Value\Role;
use Sys\Infrastructure\Test\Type\FunctionalTest;

class ClientLoginControllerFunctionalTest extends FunctionalTest
{
    private readonly ClientFixtureLoader $clientLoader;

    private const EXPECTED_TOKEN_KEYS = [
        'value', 'clientId', 'expiresAt', 'createdAt'
    ];

    private const CLIENT_USERNAME = 'username';
    private const CLIENT_PASSWORD = 'password';

    protected function setUp(): void
    {
        parent::setUp();

        $this->clientLoader = new ClientFixtureLoader($this->entityManager);
    }

    public function testClientCanLogInWithCorrectCredentials(): void
    {
        // arrange
        $clientId = $this->clientLoader->load(
            clientUsername: new ClientUsername(self::CLIENT_USERNAME),
            clientPassword: ClientPassword::hash(self::CLIENT_PASSWORD),
        );

        $requestContent = [
            'username' => self::CLIENT_USERNAME,
            'password' => self::CLIENT_PASSWORD,
            'remember' => true,
        ];

        // act
        $responseContent = $this->buildRequest()
            ->usePost('/api/v1/client/login')
            ->withContent($requestContent)
            ->getResponseContent();

        // assert
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertEquals(self::EXPECTED_TOKEN_KEYS, array_keys($responseContent));
        self::assertEquals($clientId, $responseContent['clientId']);
    }

    public function testClientCantLogInWithIncorrectCredentials(): void
    {
        // arrange
        $this->clientLoader->load(
            clientUsername: new ClientUsername(self::CLIENT_USERNAME),
            clientPassword: ClientPassword::hash(self::CLIENT_PASSWORD),
        );

        $requestContent = [
            'username' => self::CLIENT_USERNAME,
            'password' => 'drowssap',
            'remember' => true,
        ];

        // act
        $this->buildRequest()
            ->usePost('/api/v1/client/login')
            ->withContent($requestContent)
            ->getResponse();

        // assert
        self::assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }

    public function testBlockedClientCantLogIn(): void
    {
        // arrange
        $this->clientLoader->load(
            clientUsername: new ClientUsername(self::CLIENT_USERNAME),
            clientPassword: ClientPassword::hash(self::CLIENT_PASSWORD),
            role: Role::BLOCKED,
        );

        $requestContent = [
            'username' => self::CLIENT_USERNAME,
            'password' => self::CLIENT_PASSWORD,
            'remember' => true,
        ];

        // act
        $this->buildRequest()
            ->usePost('/api/v1/client/login')
            ->withContent($requestContent)
            ->getResponse();

        // assert
        self::assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
}
