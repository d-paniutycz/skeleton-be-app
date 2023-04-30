<?php

declare(strict_types=1);

namespace App\Client\Domain\Value;

use Doctrine\ORM\Mapping as ORM;
use Sys\Framework\Domain\Value\StringValue;

#[ORM\Embeddable]
final class ClientName extends StringValue
{
    #[ORM\Column(name: 'client_name')]
    protected string $value;
}
