<?php

declare(strict_types=1);

namespace App\Client\Domain;

use App\Client\Domain\Value\Token\ClientTokenExpiresAt;
use App\Client\Domain\Value\Token\ClientTokenValue;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Sys\Domain\Entity\Trait\Timestamp\EntityCreatedAtTrait;

#[ORM\Entity, ORM\HasLifecycleCallbacks]
class ClientToken
{
    use EntityCreatedAtTrait;

    #[ORM\Column, ORM\Id]
    private readonly string $value;

    #[ORM\ManyToOne(targetEntity: Client::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'cascade')]
    private readonly Client $client;

    #[ORM\Column(nullable: true)]
    protected ?DateTime $expiresAt;

    public function __construct(
        ClientTokenValue $value,
        Client $client,
        ?ClientTokenExpiresAt $expiresAt,
    ) {
        $this->value = $value->getValue();
        $this->client = $client;
        $this->expiresAt = $expiresAt?->getValue();
    }
}
