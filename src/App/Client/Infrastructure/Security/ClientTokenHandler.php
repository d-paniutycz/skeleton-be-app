<?php

declare(strict_types=1);

namespace App\Client\Infrastructure\Security;

use App\Client\Application\Repository\ClientReadRepository;
use SensitiveParameter;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

readonly class ClientTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(
        private ClientReadRepository $clientRepository,
    ) {
    }

    public function getUserBadgeFrom(
        #[SensitiveParameter] string $accessToken
    ): UserBadge {
        $id = $this->clientRepository->findIdByToken($accessToken) ?? throw new BadCredentialsException();

        return new UserBadge(
            $id->getValue()
        );
    }
}
