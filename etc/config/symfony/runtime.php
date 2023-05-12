<?php

return [
    'dotenv_path' => 'etc/config/dotenv/.env.' . $_ENV['APP_ENV'],
    'prod_envs' => ['prd'],
    'test_envs' => ['tst'],
];
