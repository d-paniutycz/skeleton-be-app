#!/usr/bin/env bash

declare BASE_DIR=$(dirname "$0")
source "$BASE_DIR/../basic.sh"

usage() {
  cat << EOF
Usage: $(basename "$0") [--help] [--verbose] (--quality | --code | <arg>...)

Perform tests on application. This script should be run from the container.

Available options:
  -h, --help        Print this help message and exit.
  -v, --verbose     Run in verbose mode, print debug information.
  --quality         Run all quality tests.
  --code            Run all code tests.

Available arguments:
  phpmd             (q) PHP Mess Detector.
  phpcs             (q) PHP Code Sniffer.
  psalm             (q) Psalm - static analysis.
  phpstan           (q) PHP Stan - static analysis.
  phpunit           (c) PHP Unit - tests.
  coverage          (c) PHP Unit - coverage.
EOF
}

setup() {
  local quality=false
  local code=false

  while :; do
    case "${1-}" in
    -h | --help) usage && exit ;;
    -v | --verbose) set -x ;;
    --quality) quality=true ;;
    --code) code=true ;;
    -?*) die "Unknown option: $1" ;;
    *) break ;;
    esac
    shift
  done

  local quality_tests=("phpmd" "phpcs" "psalm" "phpstan")
  local code_tests=("phpunit" "coverage")
  local tests=("$@")

  if [[ "$quality" == true ]]; then
    tests=("${tests[@]}" "${quality_tests[@]}")
  fi

  if [[ "$code" == true ]]; then
    tests=("${tests[@]}" "${code_tests[@]}")
  fi

  for item in "${tests[@]}"; do
    if ! [[ "${quality_tests[@]}" =~ "$item" ]] && ! [[ "${code_tests[@]}" =~ "$item" ]]; then
      die "No such test: $item"
    fi
  done

  if [[ -z "${tests[0]-}" ]]; then
    die "Missing options or arguments."
  else
    main "${tests[@]}"
  fi
}

assert_binary_is_executable() {
  local binary=$1

  if ! which "$binary" >/dev/null 2>&1 || ! [[ -x "$(command -v "$binary")" ]]; then
      die "Binary '$binary' is missing or not executable"
  fi
}

exec_php() {
  php -d error_reporting=24575 "$@"
}

run_phpmd() {
  local binary="phpmd"
  local config="$CONFIG_DIR/test/quality/phpmd.xml"

  assert_binary_is_executable "$binary"
  assert_file_exists "$config"

  exec_php $(which "$binary") "src/" ansi "$config"
}

run_phpcs() {
  local binary="phpcs"
  local config="$CONFIG_DIR/test/quality/phpcs.xml"

  assert_binary_is_executable "$binary"
  assert_file_exists "$config"

  exec_php $(which "$binary") "src/" --standard="$config" --no-cache
}

run_psalm() {
  local binary="psalm"
  local config="$CONFIG_DIR/test/quality/psalm.xml"

  assert_binary_is_executable "$binary"
  assert_file_exists "$config"

  exec_php $(which "$binary") --config="$config" --no-cache --output-format=console
}

run_phpstan() {
  local binary="phpstan"
  local config="$CONFIG_DIR/test/quality/phpstan.neon"

  assert_binary_is_executable "$binary"
  assert_file_exists "$config"

  exec_php $(which "$binary") analyse -c "$config" --xdebug
}

run_phpunit() {
  echo "(not implemented)"
}
run_coverage() {
  echo "(not implemented)"
}

main() {
  local tests=("$@")

  echo "Setup: tests=(${tests[@]})"

  for item in "${tests[@]}"; do
    print "Run: $item"

    run_$item
  done
}

setup "$@"
