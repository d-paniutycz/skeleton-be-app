<?php

declare(strict_types=1);

namespace App\Client\Application\Dto;

use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientPassword;
use App\Client\Domain\Value\ClientUsername;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;

readonly class ClientDto implements UserInterface
{
    public function __construct(
        public ClientId $id,
        public ClientUsername $username,
        #[Ignore]
        public ClientPassword $password,
    ) {
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): void
    {
        unset($this->password);
    }

    public function getUserIdentifier(): string
    {
        return $this->id->getValue();
    }
}
