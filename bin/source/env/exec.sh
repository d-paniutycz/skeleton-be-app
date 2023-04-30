#!/usr/bin/env bash

declare BASE_DIR=$(dirname "$0")
source "$BASE_DIR/../basic.sh"

usage() {
  cat << EOF
Usage: $(basename "$0") [--help] [--verbose] [--input=<path>] <command> <env>

Execute commands on environment trough Compose. This script should be run from the host.

Available options:
  -h, --help        Print this help message and exit.
  -v, --verbose     Run in verbose mode, print debug information.
  --input=<path>    Path to the env directory [default=CWD/$CONFIG_DIR] with configuration files.

Available commands:
  up                Up selected environment.
  down              Down selected environment.
  config            Test the configuration output.

Available arguments:
  <env>             The selected environment.
EOF
}

setup() {
  local input

  while :; do
    case "${1-}" in
    -h | --help) usage && exit ;;
    -v | --verbose) set -x ;;
    --input=*) input="${1#*=}" ;;
    -?*) die "Unknown option: $1" ;;
    *) break ;;
    esac
    shift
  done

  if [[ -z "${input-}" ]]; then
    input="${PWD}/$CONFIG_DIR"
  fi

  local args=("$@")
  local command

  case "${args[0]-}" in
    "up") command="up" ;;
    "down") command="down" ;;
    "config") command="config" ;;
    "") die "Missing command." ;;
    *) die "Unknown command: ${args[0]}" ;;
  esac

  if [[ -z "${args[1]-}" ]]; then
    die "Missing argument: <env>"
  else
    main "$command" "${args[1]}" "$input"
  fi
}

assert_compose_is_executable() {
  if ! docker compose version >/dev/null 2>&1; then
    die "Compose is missing or not executable."
  fi
}

exec_up() {
  assert_compose_is_executable

  docker compose -f "$1" -f "$2" --env-file "$3" up --remove-orphans --force-recreate --quiet-pull --detach
}

exec_down() {
  assert_compose_is_executable

  docker compose -f "$1" -f "$2" --env-file "$3" down --remove-orphans
}

exec_config() {
  assert_compose_is_executable

  docker compose -f "$1" -f "$2" --env-file "$3" config
}

main() {
  local command="$1"
  local env="$2"
  local input="$3"

  print "Setup: env=$env command=$command input=$input"

  local compose_main_file_path="${PWD}/docker-compose.yaml"
  local compose_env_file_path="$input/compose/docker-compose.$env.yaml"
  local dotenv_env_file_path="$input/dotenv/.env.$env"

  assert_file_exists "$compose_main_file_path"
  assert_file_exists "$compose_env_file_path"
  assert_file_exists "$dotenv_env_file_path"

  exec_$command "$compose_main_file_path" "$compose_env_file_path" "$dotenv_env_file_path"
}

setup "$@"
