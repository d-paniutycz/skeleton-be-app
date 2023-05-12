<?php

use Sys\Infrastructure\Kernel;

$_ENV['APP_RUNTIME_OPTIONS'] = require dirname(__DIR__, 1) . '/config/symfony/runtime.php';

require_once dirname(__DIR__, 2) . '/vendor/autoload_runtime.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
