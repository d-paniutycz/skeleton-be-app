<?php

declare(strict_types=1);

namespace App\Client\Application\Dto;

use App\Client\Domain\Value\ClientEmail;
use App\Client\Domain\Value\ClientId;
use App\Client\Domain\Value\ClientPassword;

readonly class ClientDto
{
    public function __construct(
        public ClientId $id,
        public ClientEmail $email,
        public ClientPassword $password,
    ) {
    }
}
