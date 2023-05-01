<?php

declare(strict_types=1);

namespace App\Client\Infrastructure\Security;

use App\Client\Application\Dto\ClientDto;
use App\Client\Application\Repository\ClientReadRepository;
use App\Client\Domain\Value\ClientId;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

readonly class ClientDtoProvider implements UserProviderInterface
{
    public function __construct(
        private ClientReadRepository $clientRepository,
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
        $clientDto = $this->clientRepository->find(
            new ClientId($identifier)
        );

        return $clientDto ?? throw new UserNotFoundException();
    }
}
