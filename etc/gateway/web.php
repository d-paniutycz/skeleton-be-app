<?php

use Sys\Framework\Infrastructure\Kernel;

$_ENV['APP_RUNTIME_OPTIONS'] = [
    'dotenv_path' => 'etc/config/env/dotenv/.env.' . $_ENV['APP_ENV'],
    'prod_envs' => ['prd'],
    'test_envs' => ['tst'],
];

require_once dirname(__DIR__, 2) . '/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
