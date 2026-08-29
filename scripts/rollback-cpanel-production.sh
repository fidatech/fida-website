#!/usr/bin/env bash

set -Eeuo pipefail
umask 077

PUBLIC_ROOT='/home/fida/public_html'
BACKUP_ROOT='/home/fida/backups'

fail() {
    printf 'ERROR: %s\n' "$*" >&2
    exit 1
}

CUTOVER_BACKUP="${1:-}"
[[ "$(id -un)" == 'fida' ]] || fail 'Run this script as the fida account.'
[[ "$(readlink -f "$PUBLIC_ROOT")" == '/home/fida/public_html' ]] || fail 'Unexpected public root.'
[[ "$CUTOVER_BACKUP" == "$BACKUP_ROOT"/fida-website-cutover-* ]] || fail 'Pass the exact cutover backup directory.'
[[ -d "$CUTOVER_BACKUP/original" ]] || fail 'The cutover backup is incomplete.'

for original_path in .htaccess index.html robots.txt sitemap.xml; do
    [[ -f "$CUTOVER_BACKUP/original/$original_path" ]] || fail "Missing backup file: $original_path"
done

ROLLBACK_ARCHIVE="$CUTOVER_BACKUP/manual-rollback-$(date -u +%Y%m%d-%H%M%S)"
mkdir -p "$ROLLBACK_ARCHIVE"

for deployed_path in .htaccess index.php build images storage favicon.svg; do
    if [[ -e "$PUBLIC_ROOT/$deployed_path" || -L "$PUBLIC_ROOT/$deployed_path" ]]; then
        mv "$PUBLIC_ROOT/$deployed_path" "$ROLLBACK_ARCHIVE/$deployed_path"
    fi
done

for original_path in .htaccess index.html robots.txt sitemap.xml; do
    if [[ -e "$PUBLIC_ROOT/$original_path" || -L "$PUBLIC_ROOT/$original_path" ]]; then
        mv "$PUBLIC_ROOT/$original_path" "$ROLLBACK_ARCHIVE/pre-restore-$original_path"
    fi
    cp -a "$CUTOVER_BACKUP/original/$original_path" "$PUBLIC_ROOT/$original_path"
done

printf 'The previous static main website was restored.\n'
printf 'The Laravel root files were preserved at %s\n' "$ROLLBACK_ARCHIVE"
printf 'No client subdomain directory was modified.\n'
