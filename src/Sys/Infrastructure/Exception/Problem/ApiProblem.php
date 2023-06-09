<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Exception\Problem;

final class ApiProblem implements \JsonSerializable
{
    public static function tokenizeType(string $value): string
    {
        return (string) crc32($value);
    }

    /**
     * @param array<array-key, mixed> $additional
     */
    public function __construct(
        private readonly string $type,
        private readonly string $title,
        private readonly string $detail,
        private readonly int $status,
        private array $additional = [],
    ) {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDetail(): string
    {
        return $this->detail;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return array<array-key, mixed>
     */
    public function getAdditional(): array
    {
        return $this->additional;
    }

    public function addAdditional(string $key, mixed $value): void
    {
        $this->additional[$key] = $value;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
