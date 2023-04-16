<?php

declare(strict_types=1);

namespace App\Client\Infrastructure\Security;

use App\Client\Application\Exception\ClientTokenExpiredException;
use App\Client\Application\Exception\ClientTokenNotFoundException;
use App\Client\Application\Repository\ClientTokenReadRepository;
use App\Client\Domain\Value\Token\ClientTokenValue;
use SensitiveParameter;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

readonly class ClientTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private ClientTokenReadRepository $readRepository,
    ) {
    }

    public function getUserBadgeFrom(
        #[SensitiveParameter] string $accessToken,
    ): UserBadge {
        $tokenDto = $this->readRepository->find(new ClientTokenValue($accessToken))
            ?? throw new ClientTokenNotFoundException();

        if ($tokenDto->expiresAt?->isExpired()) {
            throw new ClientTokenExpiredException($tokenDto->expiresAt);
        }

        return new UserBadge(
            $tokenDto->clientId->getValue()
        );
    }
}
