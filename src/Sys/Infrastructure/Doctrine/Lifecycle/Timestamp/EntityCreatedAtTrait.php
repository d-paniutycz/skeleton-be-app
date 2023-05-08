<?php

namespace Sys\Infrastructure\Doctrine\Lifecycle\Timestamp;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait EntityCreatedAtTrait
{
    #[ORM\Column]
    protected ?DateTime $createdAt;

    #[ORM\PrePersist]
    public function setCreatedAtNow(): void
    {
        $this->createdAt = new DateTime();
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt ? DateTimeImmutable::createFromMutable($this->createdAt) : null;
    }
}
