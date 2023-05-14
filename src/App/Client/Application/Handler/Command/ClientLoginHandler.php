<?php

declare(strict_types=1);

namespace App\Client\Application\Handler\Command;

use App\Client\Application\Repository\ClientReadRepository;
use App\Client\Domain\Client;
use App\Client\Port\Api\Message\Command\ClientLoginMessage;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Sys\Application\Exception\Entity\EntityNotFoundException;
use Sys\Application\Messenger\Handler\CommandHandler;
use Sys\Application\Security\SystemSecurity;

class ClientLoginHandler implements CommandHandler
{
    public function __construct(
        private readonly ClientReadRepository $clientReadRepository,
        private readonly SystemSecurity $security,
    ) {
    }

    public function __invoke(ClientLoginMessage $message): void
    {
        $clientDto = $this->clientReadRepository->findByUsername($message->username)
            ?? throw new EntityNotFoundException(Client::class, $message->username, 'username');

        if (!$clientDto->password->verify($message->password)) {
            throw new BadCredentialsException();
        }

        $this->security->loginClient($clientDto);
    }
}
