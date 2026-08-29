# Fida website production launch runbook

This runbook is a reversible operating procedure for replacing the current `fida.af` homepage with the reviewed Laravel website. It does not authorize a merge or launch. `main`, DNS, the production document root and `WEBSITE_INDEXABLE` must not change without explicit approval.

## 1. Complete the legacy URL inventory

The public crawl recorded in `docs/legacy-url-inventory.csv` verifies the current homepage, `www` host and four homepage fragments. Public search results are not an exhaustive history.

Before launch, export and combine:

- at least 16 months of Google Search Console **Pages** data;
- Bing Webmaster Tools URLs, if available;
- analytics landing pages;
- backlink destination URLs;
- access-log requests that returned `200`, `301`, `302` or recurring `404` responses.

For each verified legacy URL, either preserve it or create one direct `301`/`308` to the closest relevant public page. Do not redirect unrelated URLs to the homepage. Add reviewed path redirects through `/admin/redirects`, then run `php artisan website:release-audit` and require zero blockers.

## 2. Staging acceptance gate

Run from the staging repository after the final feature-branch deployment:

```bash
php artisan website:release-audit
php artisan website:deployment-audit https://stage.fida.af --mode=staging
npm run audit:assets
```

Required result: zero release blockers, zero release warnings, zero deployment-audit failures, and all asset budgets passing. Staging must continue to return `X-Robots-Tag: noindex, nofollow, noarchive`, block crawling in `robots.txt`, and return `404` for `/sitemap.xml`.

Manually verify the English, Dari and Pashto navigation, mobile layout, contact form, admin login, social preview and one page from every sitemap group.

## 3. Production configuration gate

Back up the production files, database and `.env` to a recoverable location before changing the document root. Record the current document root and the exact previous release path.

Required production values:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://fida.af
WEBSITE_PRODUCTION_HOST=fida.af
WEBSITE_INDEXABLE=true
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
ANALYTICS_REQUIRE_CONSENT=true
```

Also configure the real database, mail, queue, cache, Google/Bing ownership tokens, GA4 ID and IndexNow key where approved. Both `fida.af` and `www.fida.af` must have valid HTTPS coverage and point to the same release.

Before exposing the release, clear cached configuration and run the production gate with the final `.env`:

```bash
php artisan optimize:clear
php artisan website:release-audit --production --show-warnings
```

Do not continue if the command reports any blocker. Review verification warnings before launch; they may reflect ownership configured outside the application.

## 4. Build and test before maintenance mode

Development dependencies must still be installed when PHPUnit runs:

```bash
composer install --prefer-dist --optimize-autoloader --no-interaction
npm ci --ignore-scripts
npm run build
npm run audit:assets

APP_ENV=testing \
DB_CONNECTION=sqlite \
DB_DATABASE=':memory:' \
WEBSITE_INDEXABLE=true \
./vendor/bin/phpunit
```

## 5. Cutover

Only after the reviewed commit is on `main` and explicit launch approval is recorded:

1. Put the old production application into maintenance mode or enable the hosting maintenance response.
2. Deploy the reviewed `main` commit into a new release directory; do not overwrite the previous release.
3. Run `php artisan migrate --force` and the approved release seeders.
4. Run `php artisan storage:link` if the release does not already have the public storage link.
5. Install production dependencies with `composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction`.
6. Run `php artisan optimize`.
7. Point the document root or release symlink to the new `public` directory.
8. Bring the site online.

Keep the previous release directory, database backup and previous `.env` unchanged until the post-launch gate passes.

## 6. Immediate post-launch gate

Run from a host outside the production web process:

```bash
php artisan website:deployment-audit https://fida.af --mode=production
```

The audit follows no redirects automatically. It verifies:

- HTTPS and direct `www`/default-English canonical redirects;
- robots and sitemap availability;
- every URL and localized alternate found in the segmented sitemaps;
- `200` responses without redirect chains;
- self-referencing canonicals and `en`, `fa-AF`, `ps-AF`, `x-default` hreflang;
- absence of accidental `noindex` directives;
- baseline security headers and HSTS.

Then submit a real contact request, verify it in the admin lead inbox, sign in to the admin console, and confirm the social preview asset returns `200`.

If any critical check fails, re-enable maintenance mode, point the document root or symlink back to the previous release, restore the previous database only if the migration cannot be safely reversed, clear caches, and bring the previous release online.

## 7. Search activation and monitoring

Only after the production audit and manual checks pass:

```bash
php artisan website:indexnow
```

Submit `https://fida.af/sitemap.xml` in Google Search Console and Bing Webmaster Tools. Monitor indexing, crawl errors, redirect hits, recurring `404` paths, Core Web Vitals and lead delivery daily for the first week, then weekly. Keep verified legacy redirects for at least one year.
