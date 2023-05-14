<?php

declare(strict_types=1);

namespace App\Client\Port\Web\Api;

use App\Client\Application\Model\Input\ClientLoginInput;
use App\Client\Domain\Value\ClientUsername;
use App\Client\Domain\Value\Token\ClientTokenValue;
use App\Client\Port\Api\Message\Command\ClientLoginMessage;
use App\Client\Port\Api\Message\Command\ClientTokenCreateMessage;
use App\Client\Port\Api\Message\Query\ClientTokenReadMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sys\Infrastructure\Port\Web\WebController;

#[Route(path: '/api/v1/client/login')]
class ClientLoginController extends WebController
{
    #[Route(path: null, methods: Request::METHOD_POST)]
    public function login(ClientLoginInput $loginInput): Response
    {
        $this->commandBus->dispatch(
            new ClientLoginMessage(
                new ClientUsername($loginInput->username),
                $loginInput->password,
            )
        );

        $this->commandBus->dispatch(
            new ClientTokenCreateMessage(
                $tokenValue = ClientTokenValue::generate(),
                $this->security->getClientId(),
                $loginInput->remember
            )
        );

        return $this->responseFromQuery(
            new ClientTokenReadMessage($tokenValue)
        );
    }
}
