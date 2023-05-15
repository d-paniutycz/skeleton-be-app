<?php

declare(strict_types=1);

namespace App\Client\Port\Web\Api;

use App\Client\Application\Model\Input\ClientCreateInput;
use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientPassword;
use App\Client\Domain\Value\ClientUsername;
use App\Client\Port\Api\Message\Command\ClientCreateMessage;
use App\Client\Port\Api\Message\Command\ClientDeleteMessage;
use App\Client\Port\Api\Message\Query\ClientReadMessage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sys\Domain\Value\Role;
use Sys\Domain\Value\UlidValue;
use Sys\Infrastructure\Port\Web\WebController;
use Sys\Infrastructure\Security\Guard\Guard;
use Sys\Infrastructure\Security\Guard\Strategy\Role\GuardRoleNot;
use Sys\Infrastructure\Security\Guard\Strategy\Role\GuardRoleAny;

#[Route(path: '/api/v1/client', requirements: ['clientId' => UlidValue::PATTERN])]
final class ClientController extends WebController
{
    #[Route(path: null, methods: Request::METHOD_POST)]
    public function create(ClientCreateInput $createInput): Response
    {
        $this->commandBus->dispatch(
            new ClientCreateMessage(
                $clientId = ClientId::generate(),
                new ClientUsername($createInput->username),
                ClientPassword::hash($createInput->password),
            )
        );

        return $this->responseFromQuery(
            new ClientReadMessage($clientId)
        );
    }

    #[Route(path: '/{clientId}', methods: Request::METHOD_GET)]
    public function read(ClientId $clientId): Response
    {
        return $this->responseFromQuery(
            new ClientReadMessage($clientId)
        );
    }

    #[Guard(new GuardRoleAny(Role::MASTER))]
    #[Route(path: '/current', methods: Request::METHOD_GET)]
    public function current(): Response
    {
        return $this->responseFromQuery(
            new ClientReadMessage(
                new ClientId(
                    $this->security->getUserId()
                )
            )
        );
    }

    #[Route(path: '/{clientId}', methods: Request::METHOD_DELETE)]
    public function delete(ClientId $clientId): JsonResponse
    {
        $this->commandBus->dispatch(
            new ClientDeleteMessage($clientId)
        );

        return new JsonResponse();
    }
}
