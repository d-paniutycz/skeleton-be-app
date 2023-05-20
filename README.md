## Cel
Celem tego repozytorium jest przygotowanie szkieletu aplpikacji backendowej zawierajacej wszystkie narzedzia niezbedne do developmentu, testowania i procesow CI/CD.

## Requirements
- Docker Compose >=2.17
- Docker Engine >=20.10
- Bash
- Git

## Table of contents
1) [Environment](doc/readme/environment.md)
2) [Application](doc/readme/application.md)
3) [Framework](doc/readme/framework.md)
4) Releases

## Quick start
### 1) Clone
```shell
clone https://github.com/d-paniutycz/skeleton-be-app.git
cd skeleton-be-app
```

### 2) Run `dev` env and print about
```shell
bin/env exec up dev
docker exec skeleton-dev-be-app-php-1 bin/app exec about
```

### 3) Run `tst` env and perform tests
```shell
bin/env exec up tst
docker exec skeleton-tst-be-app-php-1 bin/app test --quality --code
```
