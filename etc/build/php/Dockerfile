FROM ghcr.io/d-paniutycz/skeleton-docker/be/app/php/live:1.2 AS be-app-php-release

WORKDIR /tmp/app

COPY . .

RUN set +e && set -a && source .env && set +e && set -a && \
    mv /tmp/app $APP_HOME_DIR && \
    cd $APP_HOME_DIR && \
    bin/app init composer symfony
