## Environment
`bin/env --help`

The environment can be managed using the `bin/env` script or directly through `docker compose` from the **host** machine.
The complete environment configuration consists of combining all the configuration files together, depending on the desired `<env>`.

`<env> = docker-compose.yaml + docker-compose.<env>.yaml + .env.<env>`

For example, the `dev` environment can be started with the command:
`bin/env exec up dev` and stopped with `bin/env exec down dev`.

Multiple environments can exist on a single host, but care should be taken regarding potential networking conflicts and missing external services.

Example of `docker ps`:

| PORTS                  | NAMES                     |
|------------------------|---------------------------|
| 0.0.0.0:80->80/tcp     | skeleton-dev-be-app-web-1 |
| 9000/tcp               | skeleton-dev-be-app-php-1 |
| 0.0.0.0:5432->5432/tcp | skeleton-dev-be-app-pg1-1 |
| 9000/tcp               | skeleton-tst-be-app-php-1 |
| 0.0.0.0:5433->5432/tcp | skeleton-tst-be-app-pg1-1 |

## Images
The entire environment, especially during deployment, assumes the use of baked images. Each image must be ready to run without mounting external volumes, e.g. with configuration stored in files.

The PHP service images are divided into two groups, the `tech` group contains testing and development tools while `live` is intended to be ready as a base image for release builds.

| env name | php image | xdebug | opcache | apcu | quality tools |
|----------|-----------|:------:|:-------:|:----:|:-------------:|
| dev      | tech      |   ✓    |    -    |  -   |       ✓       |
| tst      | tech      |   ✓    |    -    |  -   |       ✓       |
| stg      | live      |   -    |    ✓    |  ✓   |       -       |

The [skeleton-docker](https://github.com/d-paniutycz/skeleton-docker) repository handles the building and versioning of these images. The only exception is the release image, which is built within this repository.

## Config: Compose

`./docker-compose.yaml`

This is the main startup file where basic services and their configurations are defined, **independent** of the environment. Services are launched according to the environment that requires them, using [Compose profiles](https://docs.docker.com/compose/profiles).

Not every service needs to be used in every environment. For example, the testing environment does not require a web server, and the staging environment utilizes a database from an external service. Nevertheless, all these services are defined in this file and launched as needed.

```yaml
services:
    web:
        profiles: ['dev', 'stg']
    pg1:
        profiles: ['dev', 'tst']
```

## Config: Compose override

`./etc/config/compose/docker-compose.<env>.yaml`

All the settings for Compose services can be further configured according to the specific needs of each environment. This is the appropriate place to limit [resources](https://docs.docker.com/compose/compose-file/compose-file-v3/#resources), define [networking](https://docs.docker.com/compose/networking), and set other service parameters.

For example, the `php` service may not require multiple replicas in development, but we may need more replicas in production environment.

```yaml
# docker-compose.dev.yaml
services:
    php:
        deploy:
            mode: global
```
```yaml
# docker-compose.prd.yaml
services:
    php:
        deploy:
            mode: replicated
            replicas: 5
```

## Config: dotenv

`./etc/config/dotenv/.env.<env>`

Each environment has its own dotenv configuration. In the case of production environments, all secrets are stored in a [skeleton-docker](https://github.com/d-paniutycz/skeleton-docker) repository responsible for deploying individual services.

During deployment, the placeholders e.g. `APP_SECRET=${APP_SECRET}` from the dotenv file, will be automatically replaced with the appropriate secret value specific to the environment directly from [GitHub Secrets](https://docs.github.com/en/actions/security-guides/encrypted-secrets).
