<?php

namespace Sys\Domain\Entity\Trait\Timestamp;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait EntityUpdatedAtTrait
{
    #[ORM\Column]
    protected ?DateTime $updatedAt;

    #[ORM\PrePersist, ORM\PreUpdate]
    public function setUpdatedAtNow(): void
    {
        $this->updatedAt = new DateTime();
    }
}
