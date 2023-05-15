<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Component\Serializer;

use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;
use Sys\Infrastructure\Component\Serializer\Normalizer\ValuableNormalizer;

class ValuablePropertySerializer
{
    private Serializer $serializer;

    public function __construct()
    {
        $this->serializer = $this->build();
    }

    protected function build(): Serializer
    {
        return new Serializer(
            [
                new ValuableNormalizer(),
                new BackedEnumNormalizer(),
                new PropertyNormalizer(
                    nameConverter: new CamelCaseToSnakeCaseNameConverter()
                ),
            ],
        );
    }

    public function denormalize(mixed $data, string $type): object
    {
        /** @var object $object */
        $object = $this->serializer->denormalize($data, $type);

        return $object;
    }
}
