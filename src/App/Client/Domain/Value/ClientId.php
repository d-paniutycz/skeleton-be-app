<?php

declare(strict_types=1);

namespace App\Client\Domain\Value;

use Doctrine\ORM\Mapping as ORM;
use Sys\Domain\Value\UniqueStringIdValue;

#[ORM\Embeddable]
final class ClientId extends UniqueStringIdValue
{
    #[ORM\Id, ORM\Column(name: 'id')]
    protected string $value;
}
