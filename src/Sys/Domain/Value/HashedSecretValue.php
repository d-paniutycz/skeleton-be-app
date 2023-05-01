<?php

declare(strict_types=1);

namespace Sys\Domain\Value;

abstract class HashedSecretValue extends StringValue
{
    final public function __construct(string $value)
    {
        $value = password_hash($value, PASSWORD_ARGON2ID);

        parent::__construct($value);
    }

    public function verify(string $secret): bool
    {
        return password_verify($secret, $this->value);
    }
}
