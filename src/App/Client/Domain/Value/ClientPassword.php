<?php

declare(strict_types=1);

namespace App\Client\Domain\Value;

use Doctrine\ORM\Mapping as ORM;
use Sys\Domain\Value\HashedSecretValue;

#[ORM\Embeddable]
class ClientPassword extends HashedSecretValue
{
    #[ORM\Column(name: 'password')]
    protected string $value;
}
