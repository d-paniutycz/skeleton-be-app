<?php

declare(strict_types=1);

namespace App\Client\Infrastructure\Security;

use App\Client\Application\Model\ClientDto;
use App\Client\Application\Repository\ClientReadRepository;
use App\Client\Domain\Client;
use App\Client\Domain\Value\ClientId;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Sys\Application\Exception\Entity\EntityNotFoundException;

class ClientDtoProvider implements UserProviderInterface
{
    public function __construct(
        private readonly ClientReadRepository $readRepository,
    ) {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof ClientDto) {
            throw new UnsupportedUserException();
        }

        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return ClientDto::class === $class || is_subclass_of($class, ClientDto::class);
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $clientId = new ClientId($identifier);

        return $this->readRepository->find($clientId)
            ?? throw new EntityNotFoundException(Client::class, $clientId);
    }
}
