<?php

declare(strict_types=1);

namespace App\Client\Domain;

use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientPassword;
use App\Client\Domain\Value\ClientUsername;
use Doctrine\ORM\Mapping as ORM;
use Sys\Domain\AggregateRoot;

#[ORM\Entity, ORM\HasLifecycleCallbacks]
class Client extends AggregateRoot
{
    #[ORM\Column, ORM\Id]
    private readonly string $id;

    #[ORM\Column(unique: true)]
    private string $username;

    #[ORM\Column]
    private string $password;

    public function __construct(
        ClientId $id,
        ClientUsername $username,
        ClientPassword $password,
    ) {
        $this->id = $id->getValue();

        $this->setUsername($username);
        $this->setPassword($password);
    }

    public function getId(): ClientId
    {
        return new ClientId($this->id);
    }

    public function setUsername(ClientUsername $username): void
    {
        $this->username = $username->getValue();
    }

    public function setPassword(ClientPassword $password): void
    {
        $this->password = $password->getValue();
    }
}
