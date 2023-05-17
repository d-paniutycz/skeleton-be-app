# Config: compose
COMPOSE_PROJECT_NAME=skeleton-tst-be-app
COMPOSE_PROFILES=tst

# Config: app
APP_ENV=tst
APP_DEBUG=false
APP_SECRET=secret
APP_RELEASE=tech

# Config: app-paths
APP_HOME_DIR=/var/www/html/skeleton
APP_GATEWAY_WEB=etc/gateway/web.php
APP_GATEWAY_CLI=etc/gateway/cli.php

# Service: app-php
APP_PHP_HOST=php
APP_PHP_PORT=80
APP_PHP_IMG_URI=ghcr.io/d-paniutycz/skeleton-docker/be/app/php/tech
APP_PHP_IMG_TAG=1.3

# Service: dms-pg1
DMS_PG1_DATABASE=skeleton
DMS_PG1_VERSION=15

# Service: dms-pg1-pri (local mock)
DMS_PG1_PRI_HOST=pg1
DMS_PG1_PRI_PORT=5432
DMS_PG1_PRI_USERNAME=postgres
DMS_PG1_PRI_PASSWORD=secret

# Service: dms-pg1-rep (local mock)
DMS_PG1_REP_HOST=pg1
DMS_PG1_REP_PORT=5432
DMS_PG1_REP_USERNAME=postgres_read_only
DMS_PG1_REP_PASSWORD=secret
