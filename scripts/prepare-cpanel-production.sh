#!/usr/bin/env bash

set -Eeuo pipefail
umask 077

STAGING_REPO='/home/fida/repositories/fida-website-staging'
PRODUCTION_REPO='/home/fida/repositories/fida-website-production'
BACKUP_ROOT='/home/fida/backups'
PRODUCTION_DATABASE='fida_website_prod'

fail() {
    printf 'ERROR: %s\n' "$*" >&2
    exit 1
}

require_command() {
    command -v "$1" >/dev/null 2>&1 || fail "Required command is unavailable: $1"
}

APPROVED_SHA="${1:-}"

[[ "$APPROVED_SHA" =~ ^[0-9a-f]{40}$ ]] || fail 'Pass the approved 40-character main commit SHA.'
[[ "$(id -un)" == 'fida' ]] || fail 'Run this script as the fida account.'
[[ -d "$STAGING_REPO/.git" ]] || fail "Staging repository was not found at $STAGING_REPO."

for command_name in git php composer npm mariadb mariadb-dump; do
    require_command "$command_name"
done

git -C "$STAGING_REPO" fetch origin main:refs/remotes/origin/main
REMOTE_MAIN="$(git -C "$STAGING_REPO" rev-parse origin/main)"
[[ "$REMOTE_MAIN" == "$APPROVED_SHA" ]] || fail "origin/main is $REMOTE_MAIN, not the approved $APPROVED_SHA."

RESUME_PRODUCTION_REPO=false

if [[ -e "$PRODUCTION_REPO" ]]; then
    [[ -d "$PRODUCTION_REPO" ]] || fail "Production repository path is not a directory: $PRODUCTION_REPO"

    STAGING_COMMON_GIT_DIR="$(git -C "$STAGING_REPO" rev-parse --path-format=absolute --git-common-dir 2>/dev/null)" \
        || fail 'Could not resolve the staging Git directory.'
    PRODUCTION_COMMON_GIT_DIR="$(git -C "$PRODUCTION_REPO" rev-parse --path-format=absolute --git-common-dir 2>/dev/null)" \
        || fail "The existing production directory is not a Git worktree: $PRODUCTION_REPO"

    [[ "$PRODUCTION_COMMON_GIT_DIR" == "$STAGING_COMMON_GIT_DIR" ]] \
        || fail 'The existing production directory does not belong to the staging repository worktree set.'
    EXISTING_PRODUCTION_SHA="$(git -C "$PRODUCTION_REPO" rev-parse HEAD)"
    git -C "$STAGING_REPO" merge-base --is-ancestor "$EXISTING_PRODUCTION_SHA" "$APPROVED_SHA" \
        || fail 'The existing production worktree is not an ancestor of the approved commit.'
    [[ -z "$(git -C "$PRODUCTION_REPO" status --porcelain --untracked-files=no)" ]] \
        || fail 'The existing production worktree has tracked changes. Stop for review.'
    [[ ! -e "$PRODUCTION_REPO/.env" ]] \
        || fail 'The existing production worktree is already configured. Stop for review instead of resuming.'

    RESUME_PRODUCTION_REPO=true
fi

read -r -s -p 'Production database password: ' PRODUCTION_DATABASE_PASSWORD
printf '\n'
[[ -n "$PRODUCTION_DATABASE_PASSWORD" ]] || fail 'The production database password cannot be empty.'

TIMESTAMP="$(date -u +%Y%m%d-%H%M%S)"
PREPARE_BACKUP="$BACKUP_ROOT/fida-website-prepare-$TIMESTAMP"
mkdir -p "$PREPARE_BACKUP"

STAGING_CLIENT_FILE="$PREPARE_BACKUP/.staging-client.cnf"
PRODUCTION_CLIENT_FILE="$PREPARE_BACKUP/.production-client.cnf"

cleanup_credentials() {
    rm -f -- "$STAGING_CLIENT_FILE" "$PRODUCTION_CLIENT_FILE"
    unset PRODUCTION_DATABASE_PASSWORD
}

trap cleanup_credentials EXIT

php -r '
    $root = $argv[1];
    $target = $argv[2];
    require $root."/vendor/autoload.php";
    $app = require $root."/bootstrap/app.php";
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    $connection = (string) config("database.default");
    $database = (array) config("database.connections.".$connection);
    if (($database["driver"] ?? null) !== "mysql") {
        fwrite(STDERR, "Staging must use the MySQL driver.\n");
        exit(1);
    }
    $quote = static fn (mixed $value): string => "\"".str_replace(["\\", "\"", "\n", "\r"], ["\\\\", "\\\"", "", ""], (string) $value)."\"";
    $contents = "[client]\n"
        ."host=".$quote($database["host"] ?? "localhost")."\n"
        ."port=".$quote($database["port"] ?? "3306")."\n"
        ."user=".$quote($database["username"] ?? "")."\n"
        ."password=".$quote($database["password"] ?? "")."\n";
    file_put_contents($target, $contents, LOCK_EX);
    chmod($target, 0600);
' "$STAGING_REPO" "$STAGING_CLIENT_FILE"

FIDA_PRODUCTION_DATABASE_PASSWORD="$PRODUCTION_DATABASE_PASSWORD" php -r '
    $target = $argv[1];
    $quote = static fn (mixed $value): string => "\"".str_replace(["\\", "\"", "\n", "\r"], ["\\\\", "\\\"", "", ""], (string) $value)."\"";
    $contents = "[client]\n"
        ."host=\"localhost\"\n"
        ."port=\"3306\"\n"
        ."user=\"fida_webprod\"\n"
        ."password=".$quote(getenv("FIDA_PRODUCTION_DATABASE_PASSWORD"))."\n";
    file_put_contents($target, $contents, LOCK_EX);
    chmod($target, 0600);
' "$PRODUCTION_CLIENT_FILE"

PRODUCTION_TABLES="$(mariadb --defaults-extra-file="$PRODUCTION_CLIENT_FILE" --batch --skip-column-names --database="$PRODUCTION_DATABASE" --execute="SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = DATABASE();")"
[[ "$PRODUCTION_TABLES" == '0' ]] || fail "The production database already contains $PRODUCTION_TABLES tables. Stop for review."

if [[ "$RESUME_PRODUCTION_REPO" == true ]]; then
    printf 'Resuming the verified production worktree at %s.\n' "$PRODUCTION_REPO"
    if [[ "$EXISTING_PRODUCTION_SHA" != "$APPROVED_SHA" ]]; then
        git -C "$PRODUCTION_REPO" switch --detach "$APPROVED_SHA"
    fi
else
    git -C "$STAGING_REPO" worktree add --detach "$PRODUCTION_REPO" "$APPROVED_SHA"
fi

composer --working-dir="$PRODUCTION_REPO" install --prefer-dist --optimize-autoloader --no-interaction
npm --prefix "$PRODUCTION_REPO" ci --ignore-scripts
npm --prefix "$PRODUCTION_REPO" run build
npm --prefix "$PRODUCTION_REPO" run audit:assets

TEST_APP_KEY="$(php -r 'echo "base64:".base64_encode(random_bytes(32));')"

(
    cd "$PRODUCTION_REPO"
    APP_ENV=testing \
    APP_KEY="$TEST_APP_KEY" \
    APP_URL=http://localhost \
    DB_CONNECTION=sqlite \
    DB_DATABASE=':memory:' \
    WEBSITE_INDEXABLE=true \
        ./vendor/bin/phpunit
)

unset TEST_APP_KEY

FIDA_PRODUCTION_DATABASE_PASSWORD="$PRODUCTION_DATABASE_PASSWORD" php -r '
    $target = $argv[1];
    $password = (string) getenv("FIDA_PRODUCTION_DATABASE_PASSWORD");
    $quote = static function (string $value): string {
        $value = str_replace(["\\", "\"", "$", "\n", "\r"], ["\\\\", "\\\"", chr(92)."$", "", ""], $value);
        return "\"".$value."\"";
    };
    $lines = [
        "APP_NAME=\"Fida Technologies\"",
        "APP_ENV=production",
        "APP_KEY=",
        "APP_DEBUG=false",
        "APP_URL=https://fida.af",
        "WEBSITE_PRODUCTION_HOST=fida.af",
        "APP_TIMEZONE=Asia/Kabul",
        "WEBSITE_INDEXABLE=true",
        "WEBSITE_EMAIL=info@fida.af",
        "WEBSITE_PHONE=+93784006200",
        "WEBSITE_WHATSAPP=93784006200",
        "WEBSITE_SOCIAL_IMAGE=https://fida.af/images/fida-social-preview.png",
        "GOOGLE_SITE_VERIFICATION=",
        "BING_SITE_VERIFICATION=",
        "GOOGLE_ANALYTICS_ID=",
        "ANALYTICS_REQUIRE_CONSENT=true",
        "INDEXNOW_KEY=",
        "INDEXNOW_ENDPOINT=https://api.indexnow.org/indexnow",
        "APP_LOCALE=en",
        "APP_FALLBACK_LOCALE=en",
        "APP_FAKER_LOCALE=en_US",
        "APP_MAINTENANCE_DRIVER=file",
        "BCRYPT_ROUNDS=12",
        "LOG_CHANNEL=stack",
        "LOG_STACK=single",
        "LOG_DEPRECATIONS_CHANNEL=null",
        "LOG_LEVEL=warning",
        "DB_CONNECTION=mysql",
        "DB_HOST=localhost",
        "DB_PORT=3306",
        "DB_DATABASE=fida_website_prod",
        "DB_USERNAME=fida_webprod",
        "DB_PASSWORD=".$quote($password),
        "SESSION_DRIVER=database",
        "SESSION_LIFETIME=120",
        "SESSION_ENCRYPT=false",
        "SESSION_SECURE_COOKIE=true",
        "SESSION_HTTP_ONLY=true",
        "SESSION_PATH=/",
        "SESSION_DOMAIN=null",
        "BROADCAST_CONNECTION=log",
        "FILESYSTEM_DISK=local",
        "QUEUE_CONNECTION=database",
        "CACHE_STORE=database",
        "CACHE_PREFIX=fida_website_prod_cache",
        "MAIL_MAILER=log",
        "MAIL_FROM_ADDRESS=info@fida.af",
        "MAIL_FROM_NAME=\"Fida Technologies\"",
        "VITE_APP_NAME=\"Fida Technologies\"",
    ];
    file_put_contents($target, implode(PHP_EOL, $lines).PHP_EOL, LOCK_EX);
    chmod($target, 0600);
' "$PRODUCTION_REPO/.env"

(
    cd "$PRODUCTION_REPO"
    php artisan key:generate --force
    php artisan optimize:clear
)

STAGING_DATABASE="$(php -r '
    $root = $argv[1];
    require $root."/vendor/autoload.php";
    $app = require $root."/bootstrap/app.php";
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    echo (string) config("database.connections.".config("database.default").".database");
' "$STAGING_REPO")"
[[ "$STAGING_DATABASE" == 'fida_website_stage' ]] || fail "Unexpected staging database: $STAGING_DATABASE"

DATABASE_DUMP="$PREPARE_BACKUP/staging-database.sql"
mariadb-dump \
    --defaults-extra-file="$STAGING_CLIENT_FILE" \
    --single-transaction \
    --quick \
    --skip-lock-tables \
    --no-tablespaces \
    --default-character-set=utf8mb4 \
    "$STAGING_DATABASE" > "$DATABASE_DUMP"

mariadb \
    --defaults-extra-file="$PRODUCTION_CLIENT_FILE" \
    --default-character-set=utf8mb4 \
    "$PRODUCTION_DATABASE" < "$DATABASE_DUMP"

mkdir -p "$PRODUCTION_REPO/storage/app/public"
cp -a "$STAGING_REPO/storage/app/public/." "$PRODUCTION_REPO/storage/app/public/"

(
    cd "$PRODUCTION_REPO"
    php artisan migrate --force
    php artisan tinker --execute='
        foreach (["sessions", "password_reset_tokens", "cache", "cache_locks", "jobs", "job_batches", "failed_jobs"] as $table) {
            if (\Illuminate\Support\Facades\Schema::hasTable($table)) {
                \Illuminate\Support\Facades\DB::table($table)->delete();
            }
        }
    '
    php artisan storage:link
    php artisan website:release-audit --production --show-warnings
)

composer --working-dir="$PRODUCTION_REPO" install --no-dev --prefer-dist --optimize-autoloader --no-interaction

(
    cd "$PRODUCTION_REPO"
    php artisan optimize
)

printf '%s\n' \
    "approved_sha=$APPROVED_SHA" \
    "production_repository=$PRODUCTION_REPO" \
    "production_database=$PRODUCTION_DATABASE" \
    "database_backup=$DATABASE_DUMP" \
    > "$PREPARE_BACKUP/preparation-result.txt"

printf 'Production preparation passed.\n'
printf 'Approved SHA: %s\n' "$APPROVED_SHA"
printf 'Database backup: %s\n' "$DATABASE_DUMP"
printf 'Next: bash %s/scripts/cutover-cpanel-production.sh %s\n' "$PRODUCTION_REPO" "$APPROVED_SHA"
