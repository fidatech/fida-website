#!/usr/bin/env bash

set -Eeuo pipefail
umask 077

STAGING_REPO="${STAGING_REPO:-/home/fida/repositories/fida-website-staging}"
PRODUCTION_REPO="${PRODUCTION_REPO:-/home/fida/repositories/fida-website-production}"
PUBLIC_ROOT="${PUBLIC_ROOT:-/home/fida/public_html}"
BACKUP_ROOT="${BACKUP_ROOT:-/home/fida/backups}"

fail() {
    printf 'ERROR: %s\n' "$*" >&2
    exit 1
}

require_command() {
    command -v "$1" >/dev/null 2>&1 || fail "Required command is unavailable: $1"
}

APPROVED_SHA="${1:-}"

[[ "$APPROVED_SHA" =~ ^[0-9a-f]{40}$ ]] || fail 'Pass the approved 40-character commit SHA.'
[[ "$(id -un)" == 'fida' ]] || fail 'Run this script as the fida account.'
[[ "$(readlink -f "$PUBLIC_ROOT")" == '/home/fida/public_html' ]] || fail 'Unexpected public root.'
[[ -d "$STAGING_REPO/.git" ]] || fail "Staging repository was not found at $STAGING_REPO."
[[ -d "$PRODUCTION_REPO" ]] || fail "Production repository was not found at $PRODUCTION_REPO."
[[ -f "$PRODUCTION_REPO/.env" ]] || fail 'Production .env is missing.'

for command_name in git php composer npm mariadb mariadb-dump curl; do
    require_command "$command_name"
done

[[ -z "$(git -C "$PRODUCTION_REPO" status --porcelain --untracked-files=no)" ]]     || fail 'Production worktree has tracked changes. Stop for review.'

git -C "$STAGING_REPO" fetch origin main:refs/remotes/origin/main
REMOTE_MAIN="$(git -C "$STAGING_REPO" rev-parse origin/main)"
[[ "$REMOTE_MAIN" == "$APPROVED_SHA" ]]     || fail "origin/main is $REMOTE_MAIN, not the approved $APPROVED_SHA."

CURRENT_SHA="$(git -C "$PRODUCTION_REPO" rev-parse HEAD)"
if [[ "$CURRENT_SHA" == "$APPROVED_SHA" ]]; then
    printf 'Production is already on %s. Nothing to deploy.\n' "$APPROVED_SHA"
    exit 0
fi

git -C "$STAGING_REPO" merge-base --is-ancestor "$CURRENT_SHA" "$APPROVED_SHA"     || fail 'Refusing a non-fast-forward production deployment.'

TIMESTAMP="$(date -u +%Y%m%d-%H%M%S)"
DEPLOY_BACKUP="$BACKUP_ROOT/fida-website-deploy-$TIMESTAMP"
PUBLIC_BACKUP="$DEPLOY_BACKUP/public"
mkdir -p "$PUBLIC_BACKUP"

printf '%s\n' "$CURRENT_SHA" > "$DEPLOY_BACKUP/previous-sha.txt"
printf '%s\n' "$APPROVED_SHA" > "$DEPLOY_BACKUP/approved-sha.txt"

for live_path in .htaccess index.php build images favicon.svg 4c4d28e795ad44d1bf9c11ea59c9b7c4.txt; do
    if [[ -e "$PUBLIC_ROOT/$live_path" || -L "$PUBLIC_ROOT/$live_path" ]]; then
        cp -a "$PUBLIC_ROOT/$live_path" "$PUBLIC_BACKUP/$live_path"
    fi
done

DB_CLIENT_FILE="$DEPLOY_BACKUP/.production-client.cnf"
DB_NAME_FILE="$DEPLOY_BACKUP/.database-name"

php -r '
    $root = $argv[1];
    $client = $argv[2];
    $dbNameFile = $argv[3];
    require $root."/vendor/autoload.php";
    $app = require $root."/bootstrap/app.php";
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    $connection = (string) config("database.default");
    $database = (array) config("database.connections.".$connection);
    if (($database["driver"] ?? null) !== "mysql") {
        fwrite(STDERR, "Production must use the MySQL driver.\n");
        exit(1);
    }
    $quote = static fn (mixed $value): string => "\"".str_replace(["\\", "\"", "\n", "\r"], ["\\\\", "\\\"", "", ""], (string) $value)."\"";
    $contents = "[client]\n"
        ."host=".$quote($database["host"] ?? "localhost")."\n"
        ."port=".$quote($database["port"] ?? "3306")."\n"
        ."user=".$quote($database["username"] ?? "")."\n"
        ."password=".$quote($database["password"] ?? "")."\n";
    file_put_contents($client, $contents, LOCK_EX);
    chmod($client, 0600);
    file_put_contents($dbNameFile, (string) ($database["database"] ?? ""), LOCK_EX);
' "$PRODUCTION_REPO" "$DB_CLIENT_FILE" "$DB_NAME_FILE"

DB_NAME="$(cat "$DB_NAME_FILE")"
[[ -n "$DB_NAME" ]] || fail 'Could not resolve the production database name.'

DATABASE_DUMP="$DEPLOY_BACKUP/production-database.sql"
mariadb-dump     --defaults-extra-file="$DB_CLIENT_FILE"     --single-transaction     --quick     --skip-lock-tables     --no-tablespaces     --default-character-set=utf8mb4     "$DB_NAME" > "$DATABASE_DUMP"
[[ -s "$DATABASE_DUMP" ]] || fail 'Production database backup is empty.'

DEPLOYMENT_STARTED=false
MIGRATIONS_STARTED=false
SUCCESS=false

restore_public_files() {
    local live_path

    for live_path in .htaccess index.php build images favicon.svg; do
        if [[ -e "$PUBLIC_ROOT/$live_path" || -L "$PUBLIC_ROOT/$live_path" ]]; then
            rm -rf -- "$PUBLIC_ROOT/$live_path"
        fi
        if [[ -e "$PUBLIC_BACKUP/$live_path" || -L "$PUBLIC_BACKUP/$live_path" ]]; then
            cp -a "$PUBLIC_BACKUP/$live_path" "$PUBLIC_ROOT/$live_path"
        fi
    done
}

rollback() {
    local exit_code="$?"
    trap - ERR EXIT
    set +e

    if [[ "$SUCCESS" == true ]]; then
        rm -f -- "$DB_CLIENT_FILE" "$DB_NAME_FILE"
        exit 0
    fi

    printf 'Deployment failed. Starting automatic rollback to %s...\n' "$CURRENT_SHA" >&2

    if [[ "$MIGRATIONS_STARTED" == true && -s "$DATABASE_DUMP" ]]; then
        mariadb             --defaults-extra-file="$DB_CLIENT_FILE"             --default-character-set=utf8mb4             "$DB_NAME" < "$DATABASE_DUMP"
    fi

    if [[ "$DEPLOYMENT_STARTED" == true ]]; then
        git -C "$PRODUCTION_REPO" switch --detach "$CURRENT_SHA"
        composer --working-dir="$PRODUCTION_REPO" install             --no-dev --prefer-dist --optimize-autoloader --no-interaction
        restore_public_files
        (
            cd "$PRODUCTION_REPO"
            php artisan optimize:clear
            php artisan optimize
            php artisan up || true
        )
    fi

    rm -f -- "$DB_CLIENT_FILE" "$DB_NAME_FILE"
    printf 'Rollback completed. Backup: %s\n' "$DEPLOY_BACKUP" >&2
    exit "$exit_code"
}

trap rollback ERR EXIT

(
    cd "$PRODUCTION_REPO"
    php artisan down --retry=60
)

DEPLOYMENT_STARTED=true
git -C "$PRODUCTION_REPO" switch --detach "$APPROVED_SHA"

composer --working-dir="$PRODUCTION_REPO" install     --no-dev --prefer-dist --optimize-autoloader --no-interaction

npm --prefix "$PRODUCTION_REPO" ci --ignore-scripts
npm --prefix "$PRODUCTION_REPO" run build
npm --prefix "$PRODUCTION_REPO" run audit:assets

MIGRATIONS_STARTED=true
(
    cd "$PRODUCTION_REPO"
    php artisan optimize:clear
    php artisan migrate --force
    php artisan db:seed --class='Database\Seeders\GovernmentNgoCapabilitySeeder' --force
    php artisan website:release-audit --production --show-warnings
    php artisan optimize
)

for next_path in build images; do
    rm -rf -- "$PUBLIC_ROOT/$next_path.next"
    cp -a "$PRODUCTION_REPO/public/$next_path" "$PUBLIC_ROOT/$next_path.next"
    rm -rf -- "$PUBLIC_ROOT/$next_path"
    mv "$PUBLIC_ROOT/$next_path.next" "$PUBLIC_ROOT/$next_path"
done

cp -a "$PRODUCTION_REPO/public/favicon.svg" "$PUBLIC_ROOT/favicon.svg.next"
cp -a "$PRODUCTION_REPO/public/4c4d28e795ad44d1bf9c11ea59c9b7c4.txt" "$PUBLIC_ROOT/4c4d28e795ad44d1bf9c11ea59c9b7c4.txt.next"
cp -a "$PRODUCTION_REPO/deployment/cpanel-main-root/index.php" "$PUBLIC_ROOT/index.php.next"
cp -a "$PRODUCTION_REPO/deployment/cpanel-main-root/.htaccess" "$PUBLIC_ROOT/.htaccess.next"

chmod 0644     "$PUBLIC_ROOT/favicon.svg.next"     "$PUBLIC_ROOT/4c4d28e795ad44d1bf9c11ea59c9b7c4.txt.next"     "$PUBLIC_ROOT/index.php.next"     "$PUBLIC_ROOT/.htaccess.next"

mv -f "$PUBLIC_ROOT/favicon.svg.next" "$PUBLIC_ROOT/favicon.svg"
mv -f "$PUBLIC_ROOT/4c4d28e795ad44d1bf9c11ea59c9b7c4.txt.next" "$PUBLIC_ROOT/4c4d28e795ad44d1bf9c11ea59c9b7c4.txt"
mv -f "$PUBLIC_ROOT/index.php.next" "$PUBLIC_ROOT/index.php"
mv -f "$PUBLIC_ROOT/.htaccess.next" "$PUBLIC_ROOT/.htaccess"

for public_asset_tree in "$PUBLIC_ROOT/build" "$PUBLIC_ROOT/images"; do
    find "$public_asset_tree" -type d -exec chmod 0755 {} +
    find "$public_asset_tree" -type f -exec chmod 0644 {} +
done

chmod 0711     "$PRODUCTION_REPO"     "$PRODUCTION_REPO/storage"     "$PRODUCTION_REPO/storage/app"

if [[ -d "$PRODUCTION_REPO/storage/app/public" ]]; then
    find "$PRODUCTION_REPO/storage/app/public" -type d -exec chmod 0755 {} +
    find "$PRODUCTION_REPO/storage/app/public" -type f -exec chmod 0644 {} +
fi

(
    cd "$PRODUCTION_REPO"
    php artisan queue:restart || true
    php artisan up
)

MAIN_STATUS="$(curl --location --silent --show-error --output /dev/null --write-out '%{http_code}' --connect-timeout 12 --max-time 30 'https://fida.af/')"
[[ "$MAIN_STATUS" == '200' ]] || fail "The production homepage returned $MAIN_STATUS."

WWW_STATUS="$(curl --silent --show-error --output /dev/null --write-out '%{http_code}' --connect-timeout 12 --max-time 30 'https://www.fida.af/')"
[[ "$WWW_STATUS" == '301' ]] || fail "The www homepage returned $WWW_STATUS instead of 301."

(
    cd "$PRODUCTION_REPO"
    php artisan website:deployment-audit https://fida.af --mode=production
    php artisan website:index || printf 'Index submission skipped or failed; deployment remains healthy.\n' >&2
)

printf '%s\n' "$DEPLOY_BACKUP" > "$PRODUCTION_REPO/storage/app/latest-production-deploy-backup.txt"
printf '%s\n' "$APPROVED_SHA" > "$PRODUCTION_REPO/storage/app/latest-production-sha.txt"

SUCCESS=true
rm -f -- "$DB_CLIENT_FILE" "$DB_NAME_FILE"

printf 'Production deployment passed.\n'
printf 'Previous SHA: %s\n' "$CURRENT_SHA"
printf 'Live SHA: %s\n' "$APPROVED_SHA"
printf 'Recoverable backup: %s\n' "$DEPLOY_BACKUP"
