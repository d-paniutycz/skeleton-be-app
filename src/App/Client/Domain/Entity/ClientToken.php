<?php

declare(strict_types=1);

namespace App\Client\Domain\Entity;

use App\Client\Domain\Client;
use App\Client\Domain\Value\Token\ClientTokenValue;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ClientToken
{
    #[ORM\Column, ORM\Id]
    private readonly string $value;

    #[ORM\ManyToOne(targetEntity: Client::class)]
    #[ORM\JoinColumn(nullable: false)]
    private readonly Client $client;

    public function __construct(
        ClientTokenValue $value,
        Client $client,
    ) {
        $this->value = $value->getValue();
        $this->client = $client;
    }
}
