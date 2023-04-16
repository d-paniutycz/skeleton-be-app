<?php

use Symfony\Component\Dotenv\Dotenv;

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

if (method_exists(Dotenv::class, 'bootEnv')) {
    $runtime = require dirname(__DIR__) . '/config/symfony/runtime.php';

    (new Dotenv())->bootEnv($runtime['dotenv_path']);
}
