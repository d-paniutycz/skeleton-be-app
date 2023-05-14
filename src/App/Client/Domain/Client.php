<?php

declare(strict_types=1);

namespace App\Client\Domain;

use App\Client\Domain\Entity\ClientToken;
use App\Client\Domain\Event\ClientCreatedMessage;
use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientPassword;
use App\Client\Domain\Value\ClientUsername;
use App\Client\Domain\Value\Token\ClientTokenValue;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: ClientToken::class, cascade: ['all'])]
    private Collection $tokens;

    public function __construct(
        ClientId $id,
        ClientUsername $username,
        ClientPassword $password,
    ) {
        $this->id = $id->getValue();
        $this->username = $username->getValue();
        $this->password = $password->getValue();
        $this->tokens = new ArrayCollection();

        $this->pushEvent(
            new ClientCreatedMessage($id)
        );
    }

    public function getId(): ClientId
    {
        return new ClientId($this->id);
    }

    public function createToken(ClientTokenValue $tokenValue, bool $remember): void
    {
        $this->tokens->add(
            new ClientToken($tokenValue, $this)
        );
    }
}
