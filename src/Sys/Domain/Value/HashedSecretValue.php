<?php

declare(strict_types=1);

namespace Sys\Domain\Value;

use Sys\Application\Exception\Input\InputStringValueException;
use Sys\Domain\Value\Basic\StringValue;

abstract class HashedSecretValue extends StringValue
{
    final public static function hash(string $value): static
    {
        return new static(
            password_hash($value, PASSWORD_ARGON2ID)
        );
    }

    final public function __construct(string $value)
    {
        $info = password_get_info($value);
        if ($info['algo'] !== PASSWORD_ARGON2ID) {
            throw new InputStringValueException('Invalid Argon secret', '<moderated>');
        }

        parent::__construct($value);
    }

    public function verify(string $secret): bool
    {
        return password_verify($secret, $this->value);
    }
}
