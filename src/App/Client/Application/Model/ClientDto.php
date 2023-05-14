<?php

declare(strict_types=1);

namespace App\Client\Application\Model;

use App\Client\Domain\Value\ClientCreatedAt;
use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientPassword;
use App\Client\Domain\Value\ClientUpdatedAt;
use App\Client\Domain\Value\ClientUsername;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Ignore;

readonly class ClientDto implements UserInterface
{
    public function __construct(
        public ClientId $id,
        public ClientUsername $username,
        #[Ignore]
        public ClientPassword $password,
        public ClientCreatedAt $createdAt,
        public ClientUpdatedAt $updatedAt,
    ) {
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->id->getValue();
    }
}
