<?php

declare(strict_types=1);

namespace App\Client\Application\Dto;

use App\Client\Domain\Value\ClientEmail;
use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientPassword;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Ignore;

class ClientDto implements UserInterface
{
    public function __construct(
        public readonly ClientId $id,
        public readonly ClientEmail $email,
        #[Ignore] public ?ClientPassword $password,
    ) {
    }

    public function getRoles(): array
    {
        return [];
    }

    public function eraseCredentials(): void
    {
        $this->password = null;
    }

    public function getUserIdentifier(): string
    {
        return $this->id->getValue();
    }
}
