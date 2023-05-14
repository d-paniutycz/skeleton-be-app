<?php

declare(strict_types=1);

namespace App\Client\Infrastructure\Security;

use App\Client\Application\Repository\ClientTokenReadRepository;
use App\Client\Domain\Value\Token\ClientTokenValue;
use SensitiveParameter;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class ClientTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private readonly ClientTokenReadRepository $readRepository,
    ) {
    }

    public function getUserBadgeFrom(
        #[SensitiveParameter] string $accessToken,
    ): UserBadge {
        $tokenDto = $this->readRepository->find(new ClientTokenValue($accessToken))
            ?? throw new BadCredentialsException();

        return new UserBadge(
            $tokenDto->clientId->getValue()
        );
    }
}
