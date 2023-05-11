<?php

namespace Sys\Domain\Entity\Trait\Timestamp;

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
}
