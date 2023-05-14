<?php

declare(strict_types=1);

namespace App\Client\Application\Handler\Command;

use App\Client\Application\Exception\ClientBadCredentialsException;
use App\Client\Application\Repository\ClientReadRepository;
use App\Client\Port\Api\ClientSecurity;
use App\Client\Port\Api\Message\Command\ClientLoginMessage;
use Sys\Application\Messenger\Handler\CommandHandler;

readonly class ClientLoginHandler implements CommandHandler
{
    public function __construct(
        private ClientReadRepository $clientReadRepository,
        private ClientSecurity $security,
    ) {
    }

    public function __invoke(ClientLoginMessage $message): void
    {
        $clientDto = $this->clientReadRepository->findByUsername($message->username)
            ?? throw new ClientBadCredentialsException();

        if (!$clientDto->password->verify($message->password)) {
            throw new ClientBadCredentialsException();
        }

        $this->security->loginClient($clientDto);
    }
}
