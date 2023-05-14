<?php

declare(strict_types=1);

namespace App\Client\Domain\Value\Token;

use DateTime;
use Sys\Domain\Value\Basic\DateTimeValue;

class ClientTokenExpiresAt extends DateTimeValue
{
    public function isExpired(): bool
    {
        return $this->value < new DateTime();
    }
}
