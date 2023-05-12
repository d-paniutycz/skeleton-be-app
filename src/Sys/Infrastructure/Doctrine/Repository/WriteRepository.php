<?php

declare(strict_types=1);

namespace Sys\Infrastructure\Doctrine\Repository;

interface WriteRepository
{
    public function save(object $entity): void;

    public function delete(object $entity): void;
}
