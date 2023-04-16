<?php

declare(strict_types=1);

namespace App\Client\Application\Model\Input;

use Symfony\Component\Validator\Constraints as Assert;
use Sys\Infrastructure\Port\Web\Resolver\Request\ResolvableRequest;
use Sys\Infrastructure\Port\Web\Resolver\Request\Strategy\JsonContentResolverStrategy;
use Sys\Infrastructure\Port\Web\Resolver\Request\Strategy\RequestResolverStrategy;

class ClientLoginInput implements ResolvableRequest
{
    #[Assert\Type('alnum')]
    #[Assert\Length(min: 8, max: 32)]
    public string $username;

    #[Assert\Length(min: 8, max: 32)]
    public string $password;

    public bool $remember;

    public function __construct(
        string $username,
        string $password,
        bool $remember,
    ) {
        $this->username = $username;
        $this->password = $password;
        $this->remember = $remember;
    }

    public static function getRequestResolver(): RequestResolverStrategy
    {
        return new JsonContentResolverStrategy();
    }
}
