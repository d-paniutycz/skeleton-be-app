<?php

declare(strict_types=1);

namespace App\Client\Domain\Value;

use Doctrine\ORM\Mapping as ORM;
use Sys\Domain\Value\EmailValue;

#[ORM\Embeddable]
class ClientEmail extends EmailValue
{
    #[ORM\Column(name: 'email', unique: true)]
    protected string $value;
}
