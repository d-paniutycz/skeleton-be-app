#!/usr/bin/env bash

declare BASE_DIR=$(dirname "$0")
source "$BASE_DIR/../basic.sh"

usage() {
  cat << EOF
Usage: $(basename "$0") [--help] [--verbose] [--force] <arg>...

Initialize application subsystems. This script should be run from the container.

Available options:
  -h, --help        Print this help message and exit.
  -v, --verbose     Run in verbose mode, print debug information.
  --force           Force decisions.

Available arguments:
  composer          Initialize Composer, install vendor packages based on current environment.
  symfony           Initialize Symfony.
  doctrine          Initialize Doctrine.
EOF
}

setup() {
  FORCE=false

  while :; do
    case "${1-}" in
    -h | --help) usage && exit ;;
    -v | --verbose) set -x ;;
    --force) FORCE=true ;;
    -?*) die "Unknown option: $1" ;;
    *) break ;;
    esac
    shift
  done

  local args=("$@")

  local composer=false
  local symfony=false
  local doctrine=false

  for arg in "${args[@]}"; do
    case "$arg" in
      "composer") composer=true ;;
      "symfony") symfony=true ;;
      "doctrine") doctrine=true ;;
      *) die "Unknown argument: $arg" ;;
    esac
  done

  main "$composer" "$symfony" "$doctrine"
}

assert_composer_is_executable() {
  if ! [[ -x "$(command -v composer)" ]]; then
    die "Composer is missing or not executable."
  fi
}

assert_composer_config_exists() {
  if ! [[ -f "composer.json" ]] && ! [[ -f "composer.lock" ]]; then
    die "Composer configuration is missing."
  fi
}

composer_install() {
  assert_composer_is_executable
  assert_composer_config_exists

  if [[ "$APP_ENV" == "dev" ]] || [[ "$APP_ENV" == "tst" ]]; then
    composer install
  else
    composer install --no-dev
  fi
}

init_composer() {
  if ! [[ -d "vendor" ]] || [[ "$FORCE" == true ]]; then
    composer_install
  fi

  print "Composer: OK"
}

init_symfony() {
  bin/app exec cache:warmup

  print "Symfony: OK"
}

init_doctrine() {
  bin/app exec --no-interaction doctrine:migrations:migrate

  print "Doctrine: OK"
}

main() {
  assert_env_initialized

  local composer="$1"
  local symfony="$2"
  local doctrine="$3"

  print "Setup: force=$FORCE composer=$composer symfony=$symfony doctrine=$doctrine"

  # order of execution is important
  if [[ "$composer" == true ]]; then
    init_composer
  fi

  if [[ "$symfony" == true ]]; then
    init_symfony
  fi

  if [[ "$doctrine" == true ]]; then
    init_doctrine
  fi
}

setup "$@"
