<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Component\Serializer;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;

readonly class PublicDataSerializer
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
                new JsonSerializableNormalizer(),
                new PropertyNormalizer(
                    new ClassMetadataFactory(
                        new AnnotationLoader()
                    ),
                    defaultContext: [
                        PropertyNormalizer::NORMALIZE_VISIBILITY => PropertyNormalizer::NORMALIZE_PUBLIC
                    ],
                ),
            ],
            [
                new JsonEncoder()
            ],
        );
    }

    public function serialize(mixed $data, string $format = 'json'): string
    {
        return $this->serializer->serialize($data, $format);
    }
}
