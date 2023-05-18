<?php

namespace App\Test\Client\Port\Web\Api;

use App\Client\Domain\Value\Token\ClientTokenValue;
use App\Test\Client\Test\ClientFixtureLoader;
use Symfony\Component\HttpFoundation\Response;
use Sys\Domain\Value\Role;
use Sys\Infrastructure\Test\Type\FunctionalTest;

class ClientControllerFunctionalTest extends FunctionalTest
{
    private readonly ClientFixtureLoader $clientLoader;

    private readonly ClientTokenValue $tokenValue;

    private const EXPECTED_CLIENT_KEYS = [
        'id', 'username', 'role', 'createdAt', 'updatedAt'
    ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->clientLoader = new ClientFixtureLoader($this->entityManager);

        $this->tokenValue = ClientTokenValue::generate();
    }

    public function testCreatingClient(): void
    {
        // arrange
        $requestContent = [
            'username' => 'username',
            'password' => 'password',
        ];

        // act
        $responseContent = $this->buildRequest()
            ->usePost('/api/v1/client')
            ->withContent($requestContent)
            ->getResponseContent();

        // assert
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertEquals(self::EXPECTED_CLIENT_KEYS, array_keys($responseContent));
        self::assertEquals($requestContent['username'], $responseContent['username']);
    }

    public function testReadingCurrentClient(): void
    {
        // arrange
        $clientId = $this->clientLoader->load(tokenValue: $this->tokenValue);

        // act
        $responseContent = $this->buildRequest()
            ->useGet('/api/v1/client/current')
            ->withToken($this->tokenValue)
            ->getResponseContent();

        // assert
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertEquals(self::EXPECTED_CLIENT_KEYS, array_keys($responseContent));
        self::assertEquals($clientId, $responseContent['id']);
    }

    public function testMasterCanReadClient(): void
    {
        // arrange
        $clientId = $this->clientLoader->load();
        $this->clientLoader->load(role: Role::MASTER, tokenValue: $this->tokenValue);

        // act
        $responseContent = $this->buildRequest()
            ->useGet('/api/v1/client/' . $clientId)
            ->withToken($this->tokenValue)
            ->getResponseContent();

        // assert
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
        self::assertEquals(self::EXPECTED_CLIENT_KEYS, array_keys($responseContent));
        self::assertEquals($clientId, $responseContent['id']);
    }

    public function testMasterCanDeleteClient(): void
    {
        // arrange
        $clientId = $this->clientLoader->load();
        $this->clientLoader->load(role: Role::MASTER, tokenValue: $this->tokenValue);

        // act
        $this->buildRequest()
            ->useDelete('/api/v1/client/' . $clientId)
            ->withToken($this->tokenValue)
            ->getResponse();

        // assert
        self::assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
