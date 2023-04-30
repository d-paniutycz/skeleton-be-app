<?php

declare(strict_types=1);

namespace App\Client\Domain;

use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientName;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Client
{
    #[ORM\Embedded(columnPrefix: false)]
    private readonly ClientId $clientId;

    #[ORM\Embedded(columnPrefix: false)]
    private ClientName $clientName;

    public function __construct(
        ClientId $clientId,
        ClientName $clientName,
    ) {
        $this->clientId = $clientId;
        $this->clientName = $clientName;
    }

    public function getClientId(): ClientId
    {
        return $this->clientId;
    }

    public function getClientName(): ClientName
    {
        return $this->clientName;
    }

    public function setClientName(ClientName $clientName): void
    {
        $this->clientName = $clientName;
    }
}
