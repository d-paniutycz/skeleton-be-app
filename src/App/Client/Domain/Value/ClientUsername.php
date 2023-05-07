<?php

declare(strict_types=1);

namespace App\Client\Domain\Value;

use Doctrine\ORM\Mapping as ORM;
use Sys\Domain\Value\Basic\StringValue;

#[ORM\Embeddable]
class ClientUsername extends StringValue
{
    #[ORM\Column(name: 'username', unique: true)]
    protected string $value;
}
