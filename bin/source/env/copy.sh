#!/usr/bin/env bash

declare BASE_DIR=$(dirname "$0")
source "$BASE_DIR/../basic.sh"

usage() {
  cat << EOF
Usage: $(basename "$0") [--help] [--verbose] [--main] [--input=<path>] [--output=<path>] <env>

Copy environment configuration files. This script should be run from the host.

Available options:
  -h, --help        Print this help message and exit.
  -v, --verbose     Run in verbose mode, print debug information.
  --main            Copy as the main configuration without <env> in names.
  --input=<path>    Path to the env directory [default=CWD/$CONFIG_DIR] with configuration files.
  --output=<path>   Path to the output directory [default=CWD] where files should be copied.

Available arguments:
  <env>             The selected environment.
EOF
}

setup() {
  local main=false
  local input
  local output

  while :; do
    case "${1-}" in
    -h | --help) usage && exit;;
    -v | --verbose) set -x ;;
    --main) main=true ;;
    --input=*) input="${1#*=}" ;;
    --output=*) output="${1#*=}" ;;
    -?*) die "Unknown option: $1" ;;
    *) break ;;
    esac
    shift
  done

  if [[ -z "${input-}" ]]; then
    input="${PWD}/$CONFIG_DIR"
  fi

  if [[ -z "${output-}" ]]; then
    output="${PWD}"
  fi

  local args=("$@")

  if [[ -z "${args[0]-}" ]]; then
    die "Missing argument: <env>"
  else
    main "${args[0]}" "$main" "$input" "$output"
  fi
}

main() {
  local env="$1"
  local main="$2"
  local input="$3"
  local output="$4"

  print "Setup: env=$env main=$main input=$input output=$output"

  local dotenv_env_file_name=".env.$env"
  local compose_env_file_name="docker-compose.$env.yaml"

  local dotenv_env_file_path="$input/dotenv/$dotenv_env_file_name"
  local compose_env_file_path="$input/compose/$compose_env_file_name"

  assert_file_exists "$dotenv_env_file_path"
  assert_file_exists "$compose_env_file_path"

  local dotenv_file_name=".env"
  local compose_file_name="docker-compose.override.yaml"

  if [[ "$main" == false ]]; then
    dotenv_file_name="$dotenv_env_file_name"
    compose_file_name="$compose_env_file_name"
  fi

  if ! [[ -e "$output" ]]; then
    mkdir -p "$output"
  fi

  cp -p "$dotenv_env_file_path" "$output/$dotenv_file_name"
  cp -p "$compose_env_file_path" "$output/$compose_file_name"
}

setup "$@"
