<?php

namespace Sys\Infrastructure\Test\Helper\Trait;

use RuntimeException;
use Sys\Infrastructure\Kernel;

trait KernelContainerHelperTrait
{
    final protected static function getKernelClass(): string
    {
        return Kernel::class;
    }

    protected function getService(string $id): object
    {
        $service = self::getContainer()->get($id);

        if (!is_object($service)) {
            throw new RuntimeException('Could not retrieve service with id: ' . $id);
        }

        return $service;
    }

    protected function setService(string $id, object $service): void
    {
        self::getContainer()->set($id, $service);
    }
}
