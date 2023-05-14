<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Security;

use App\Client\Application\Model\ClientDto;
use App\Client\Domain\Value\ClientId;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sys\Application\Exception\Entity\EntityNotFoundException;
use Sys\Application\Security\SystemSecurity;

class SymfonySecurity implements SystemSecurity
{
    public function __construct(
        private readonly Security $security,
    ) {
    }

    public function getClient(): ?ClientDto
    {
        /** @var ?ClientDto $user */
        $user = $this->security->getUser();

        return $user;
    }

    public function getClientId(): ClientId
    {
        /** @var ?ClientDto $user */
        $user = $this->security->getUser();
        if (is_null($user)) {
            throw new AccessDeniedException();
        }

        return $user->id;
    }

    public function loginClient(ClientDto $clientDto): void
    {
        $this->security->login($clientDto);
    }
}
