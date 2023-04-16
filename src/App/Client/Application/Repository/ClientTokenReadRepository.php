<?php

declare(strict_types=1);

namespace App\Client\Application\Repository;

use App\Client\Application\Model\ClientTokenDto;
use App\Client\Domain\Value\Token\ClientTokenValue;

interface ClientTokenReadRepository
{
    public function find(ClientTokenValue $value): ?ClientTokenDto;
}
