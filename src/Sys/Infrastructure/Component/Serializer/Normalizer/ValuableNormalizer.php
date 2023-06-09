<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Component\Serializer\Normalizer;

use BackedEnum;
use RuntimeException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Sys\Domain\Value\Basic\Valuable;

class ValuableNormalizer implements DenormalizerInterface
{
    /**
     * @param array<array-key, mixed> $context
     */
    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): Valuable
    {
        // @TODO: check format after basic array value introduced
        unset($context, $format);

        if (!is_subclass_of($type, Valuable::class)) {
            throw new RuntimeException('Not a Valuable type: ' . $type);
        }

        return new $type($data);
    }

    public function supportsDenormalization(mixed $data, string $type, string $format = null): bool
    {
        if (null === $data || !is_subclass_of($type, Valuable::class)) {
            return false;
        }

        // lets resolve Valuable enums elsewhere
        if (is_subclass_of($type, BackedEnum::class)) {
            return false;
        }

        if ('json' === $format || is_null($format)) {
            return true;
        }

        return false;
    }
}
