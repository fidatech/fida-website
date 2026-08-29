#!/usr/bin/env bash

set -Eeuo pipefail
umask 077

PRODUCTION_REPO='/home/fida/repositories/fida-website-production'
PUBLIC_ROOT='/home/fida/public_html'
BACKUP_ROOT='/home/fida/backups'

PROTECTED_HEALTHY_HOSTS=(
    accounts.fida.af
    ahmadzailtd.fida.af
    hikmat.fida.af
    hrm.fida.af
    javidghaznawi.fida.af
    lutfullah.fida.af
    nawi-almadina.fida.af
    pharmacy.fida.af
    poya.fida.af
    prime.fida.af
    pro.pts.fida.af
    roznamcha.fida.af
    sarafi-lite.fida.af
    sarafi-pro.fida.af
    umer.fida.af
)

KNOWN_PREEXISTING_UNREACHABLE_HOSTS=(
    hafiz.fida.af
    katawazai.fida.af
    lite.pts.fida.af
    sahargul.fida.af
)

fail() {
    printf 'ERROR: %s\n' "$*" >&2
    exit 1
}

APPROVED_SHA="${1:-}"
[[ "$APPROVED_SHA" =~ ^[0-9a-f]{40}$ ]] || fail 'Pass the approved 40-character main commit SHA.'
[[ "$(id -un)" == 'fida' ]] || fail 'Run this script as the fida account.'
[[ "$(readlink -f "$PUBLIC_ROOT")" == '/home/fida/public_html' ]] || fail 'Unexpected public root.'
[[ -d "$PRODUCTION_REPO" ]] || fail 'Prepared production repository is missing.'
[[ "$(git -C "$PRODUCTION_REPO" rev-parse HEAD)" == "$APPROVED_SHA" ]] || fail 'Production repository is not on the approved commit.'
[[ -f "$PRODUCTION_REPO/vendor/autoload.php" ]] || fail 'Production dependencies are missing.'
[[ -f "$PRODUCTION_REPO/public/build/manifest.json" ]] || fail 'Production asset manifest is missing.'
[[ -f "$PRODUCTION_REPO/deployment/cpanel-main-root/.htaccess" ]] || fail 'Host-scoped cPanel .htaccess is missing.'
[[ -f "$PRODUCTION_REPO/deployment/cpanel-main-root/index.php" ]] || fail 'cPanel front controller is missing.'

for protected_host in "${PROTECTED_HEALTHY_HOSTS[@]}" "${KNOWN_PREEXISTING_UNREACHABLE_HOSTS[@]}"; do
    [[ -d "$PUBLIC_ROOT/$protected_host" ]] || fail "Protected client directory is missing: $protected_host"
done

for new_path in index.php build images storage favicon.svg .htaccess.next; do
    [[ ! -e "$PUBLIC_ROOT/$new_path" && ! -L "$PUBLIC_ROOT/$new_path" ]] || fail "Refusing to overwrite existing public path: $PUBLIC_ROOT/$new_path"
done

for existing_path in .htaccess index.html robots.txt sitemap.xml; do
    [[ -f "$PUBLIC_ROOT/$existing_path" ]] || fail "Expected static-site file is missing: $PUBLIC_ROOT/$existing_path"
done

check_client_hosts() {
    local phase="$1"
    local host
    local result

    for host in "${PROTECTED_HEALTHY_HOSTS[@]}"; do
        result="$(curl --location --silent --show-error --output /dev/null --write-out '%{http_code}' --connect-timeout 12 --max-time 30 "https://$host/")" || result='000'
        printf '%-38s %s %s\n' "$host" "$phase" "$result"
        [[ "$result" == '200' ]] || return 1
    done
}

printf 'Confirming the pre-cutover client baseline...\n'
check_client_hosts before || fail 'A previously healthy client system is not returning 200. No cutover was performed.'

(
    cd "$PRODUCTION_REPO"
    php artisan optimize:clear
    php artisan website:release-audit --production --show-warnings
    php artisan optimize
)

TIMESTAMP="$(date -u +%Y%m%d-%H%M%S)"
CUTOVER_BACKUP="$BACKUP_ROOT/fida-website-cutover-$TIMESTAMP"
FAILED_RELEASE="$CUTOVER_BACKUP/failed-release"
mkdir -p "$CUTOVER_BACKUP/original" "$FAILED_RELEASE"

for existing_path in .htaccess index.html robots.txt sitemap.xml; do
    cp -a "$PUBLIC_ROOT/$existing_path" "$CUTOVER_BACKUP/original/$existing_path"
done

printf '%s\n' "$APPROVED_SHA" > "$CUTOVER_BACKUP/approved-sha.txt"

rollback_required=false

rollback() {
    local exit_code="${1:-1}"
    trap - ERR
    set +e

    if [[ "$rollback_required" == true ]]; then
        if [[ -f "$CUTOVER_BACKUP/rollback-completed" ]]; then
            printf 'The previous static website was already restored from %s\n' "$CUTOVER_BACKUP" >&2
            exit "$exit_code"
        fi

        printf 'Cutover verification failed; restoring the previous static website...\n' >&2

        for deployed_path in .htaccess index.php build images storage favicon.svg; do
            if [[ -e "$PUBLIC_ROOT/$deployed_path" || -L "$PUBLIC_ROOT/$deployed_path" ]]; then
                mv "$PUBLIC_ROOT/$deployed_path" "$FAILED_RELEASE/$deployed_path"
            fi
        done

        for original_path in .htaccess index.html robots.txt sitemap.xml; do
            if [[ -e "$PUBLIC_ROOT/$original_path" || -L "$PUBLIC_ROOT/$original_path" ]]; then
                mv "$PUBLIC_ROOT/$original_path" "$FAILED_RELEASE/pre-restore-$original_path"
            fi
            cp -a "$CUTOVER_BACKUP/original/$original_path" "$PUBLIC_ROOT/$original_path"
        done

        touch "$CUTOVER_BACKUP/rollback-completed"
        printf 'Previous main website restored from %s\n' "$CUTOVER_BACKUP" >&2
    fi

    exit "$exit_code"
}

trap 'rollback $?' ERR

rollback_required=true
cp -a "$PRODUCTION_REPO/public/build" "$PUBLIC_ROOT/build"
cp -a "$PRODUCTION_REPO/public/images" "$PUBLIC_ROOT/images"
cp -a "$PRODUCTION_REPO/public/favicon.svg" "$PUBLIC_ROOT/favicon.svg"
ln -s "$PRODUCTION_REPO/storage/app/public" "$PUBLIC_ROOT/storage"
cp -a "$PRODUCTION_REPO/deployment/cpanel-main-root/index.php" "$PUBLIC_ROOT/index.php"
cp -a "$PRODUCTION_REPO/deployment/cpanel-main-root/.htaccess" "$PUBLIC_ROOT/.htaccess.next"

# Git created the prepared worktree under umask 077. Publish only the apex
# entry points and static assets with web-readable modes; client directories
# are deliberately excluded from every permission change.
chmod 0644 \
    "$PUBLIC_ROOT/index.php" \
    "$PUBLIC_ROOT/favicon.svg" \
    "$PUBLIC_ROOT/.htaccess.next"

for public_asset_tree in "$PUBLIC_ROOT/build" "$PUBLIC_ROOT/images"; do
    find "$public_asset_tree" -type d -exec chmod 0755 {} +
    find "$public_asset_tree" -type f -exec chmod 0644 {} +
done

# Apache must be able to traverse the storage symlink target. Application
# source remains non-listable, and PHP continues to execute as the fida user.
chmod 0711 \
    "$PRODUCTION_REPO" \
    "$PRODUCTION_REPO/storage" \
    "$PRODUCTION_REPO/storage/app"
find "$PRODUCTION_REPO/storage/app/public" -type d -exec chmod 0755 {} +
find "$PRODUCTION_REPO/storage/app/public" -type f -exec chmod 0644 {} +

mv "$PUBLIC_ROOT/robots.txt" "$CUTOVER_BACKUP/original/robots.txt.live"
mv "$PUBLIC_ROOT/sitemap.xml" "$CUTOVER_BACKUP/original/sitemap.xml.live"
mv "$PUBLIC_ROOT/.htaccess" "$CUTOVER_BACKUP/original/.htaccess.live"
mv "$PUBLIC_ROOT/.htaccess.next" "$PUBLIC_ROOT/.htaccess"
mv "$PUBLIC_ROOT/index.html" "$CUTOVER_BACKUP/original/index.html.live"

(
    trap - ERR
    cd "$PRODUCTION_REPO"
    php artisan website:deployment-audit https://fida.af --mode=production
)

check_client_hosts after

MAIN_STATUS="$(curl --location --silent --show-error --output /dev/null --write-out '%{http_code}' --connect-timeout 12 --max-time 30 'https://fida.af/')"
[[ "$MAIN_STATUS" == '200' ]] || fail "The production homepage returned $MAIN_STATUS."

WWW_STATUS="$(curl --silent --show-error --output /dev/null --write-out '%{http_code}' --connect-timeout 12 --max-time 30 'https://www.fida.af/')"
[[ "$WWW_STATUS" == '301' ]] || fail "The www homepage returned $WWW_STATUS instead of 301."

rollback_required=false
trap - ERR

printf '%s\n' "$CUTOVER_BACKUP" > "$PRODUCTION_REPO/storage/app/production-cutover-backup.txt"

printf 'Production cutover passed.\n'
printf 'Live SHA: %s\n' "$APPROVED_SHA"
printf 'Recoverable cutover backup: %s\n' "$CUTOVER_BACKUP"
printf 'Known pre-existing 000 hosts were not changed: %s\n' "${KNOWN_PREEXISTING_UNREACHABLE_HOSTS[*]}"
