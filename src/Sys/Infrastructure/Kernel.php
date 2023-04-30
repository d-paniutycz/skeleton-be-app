<?php

namespace Sys\Infrastructure;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function getConfigDir(): string
    {
        return $this->getProjectDir() . '/etc/config/symfony';
    }
}
