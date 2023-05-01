<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Security;

use App\Client\Application\Dto\ClientDto;
use Symfony\Bundle\SecurityBundle\Security;
use Sys\Application\Security\SystemSecurity;

class SecurityAdapter implements SystemSecurity
{
    public function __construct(
        private readonly Security $security,
    ) {
    }

    public function getClient(): ?ClientDto
    {
        /** @var ?ClientDto $clientDto */
        $clientDto = $this->security->getUser();

        return $clientDto;
    }
}
