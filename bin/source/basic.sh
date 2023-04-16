#!/usr/bin/env bash

set -Eeuo pipefail
trap cleanup SIGINT SIGTERM ERR EXIT

declare CONFIG_DIR="etc/config"

declare COLOR_END="\e[0m"
declare COLOR_RED="\e[31m"
declare COLOR_GREEN="\e[32m"

cleanup() {
  trap - SIGINT SIGTERM ERR EXIT
}

print() {
  echo >&2 -e "${1-}"
}

die() {
  print "${COLOR_RED}ERROR${COLOR_END} $1" && exit "${2-1}"
}

assert_file_exists() {
  local file=$1

  if ! [[ -f "$file" ]]; then
    die "File '$file' not found."
  fi

  return 0
}

assert_env_initialized() {
  if ! [[ -n "${APP_ENV+x}" ]]; then
    die "Environment is uninitialized."
  fi
}
