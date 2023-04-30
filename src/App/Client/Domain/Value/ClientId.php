<?php

declare(strict_types=1);

namespace App\Client\Domain\Value;

use Doctrine\ORM\Mapping as ORM;
use Sys\Framework\Domain\Value\UniqueStringValue;

#[ORM\Embeddable]
final class ClientId extends UniqueStringValue
{
    #[ORM\Id, ORM\Column(name: 'client_id')]
    protected string $value;
}
