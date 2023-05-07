<?php

declare(strict_types=1);

namespace App\Client\Domain;

use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientPassword;
use App\Client\Domain\Value\ClientUsername;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Client
{
    public function __construct(
        #[ORM\Id]
        #[ORM\Column(type: 'string')]
        private readonly ClientId $id,
        #[ORM\Column(type: 'string', unique: true)]
        private readonly ClientUsername $username,
        #[ORM\Column(type: 'string')]
        private ClientPassword $password,
    ) {
    }

    public function getId(): ClientId
    {
        return $this->id;
    }

    public function getUsername(): ClientUsername
    {
        return $this->username;
    }

    public function getPassword(): ClientPassword
    {
        return $this->password;
    }

    public function setPassword(ClientPassword $password): void
    {
        $this->password = $password;
    }
}
