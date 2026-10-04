# Fida Technologies Website

Official multilingual website and lead-generation platform for [Fida Technologies](https://fida.af).

## Foundation

- Laravel 13 with server-rendered Blade pages
- Tailwind CSS 4 and minimal JavaScript
- English, Dari and Pashto with RTL support
- Dedicated CMS-backed About, Services, Projects, Pricing and Contact sections with localized routes
- Dynamic multilingual landing-page content
- Dedicated multilingual profiles for Realist ERP, Prime Sarafi, Darmal ERP and OGRAYI
- Search metadata, canonical URLs, hreflang, XML sitemap and page-specific structured data
- Per-page discovery strategy, robots policy, social previews, editorial trust fields and publishing-readiness audits
- Automatic multilingual one-hop redirects when slugs change, plus an admin redirect manager
- Visible multilingual FAQs, service/software entities, breadcrumbs and related-topic internal links
- Google and Bing ownership verification hooks, current AI search/user crawler policy and IndexNow submission
- Canonical company-facts and Fida Answers pages plus AI-referral and AI-crawler visibility reporting
- Automatic after-response IndexNow notification for content changes when production credentials are configured
- Consent-based GA4 loading, conversion events and campaign-attributed lead capture
- Automated PHP tests and frontend build verification
- Separate authenticated website console for content, leads and team access
- Database-backed brand settings for logo, company contacts, address, approved map embeds, surface themes and color palettes

The seeder also creates one private case-study draft per product. They are intentionally excluded from public routes and the sitemap until the client, implementation facts, redacted screenshots and measurable outcomes are verified and approved.

## Local setup

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm install
npm run build
php artisan serve
```

Create the first administrator interactively (no default credentials are seeded):

```bash
php artisan website:make-admin
```

The secure console is available at `/admin`. Available roles are:

- `super_admin`: all console areas, including team access
- `editor`: multilingual content and search metadata
- `sales`: customer leads and opportunity pipeline

Primary public routes are available in English at `/about`, `/services`, `/projects`, `/pricing` and `/contact`. Dari and Pashto use the same page slugs below `/fa` and `/ps`. The homepage remains an overview, while the primary navigation points to these standalone pages.

Super administrators can manage the public identity from `/admin/settings`. The selected surface theme and palette apply to both the public website and administration console. Company details also feed the public contact areas and Organization structured data. Uploaded logos use Laravel's public disk, so each deployment needs the public storage link:

```bash
php artisan storage:link
```

Editors can document the primary search topic, visitor intent, robots policy, social preview and verified editorial responsibility on every content item. The readiness audit is advisory: it highlights missing or weak discovery inputs without encouraging filler or blocking an editor from publishing accurate time-sensitive content. Changing a slug automatically preserves the previous English, Dari and Pashto URLs as direct permanent redirects. Manual legacy redirects are managed at `/admin/redirects`.

Run the verification suite:

```bash
php artisan test
npm run build
```

## Search launch setup

Staging and preview hosts must stay out of search results. Hosts beginning with `stage.` are automatically non-indexable; make the intent explicit in the staging `.env`:

```dotenv
WEBSITE_INDEXABLE=false
```

After the production domain is serving the new site, add the ownership tokens from Google Search Console and Bing Webmaster Tools to `.env`:

```dotenv
GOOGLE_SITE_VERIFICATION=
BING_SITE_VERIFICATION=
GOOGLE_ANALYTICS_ID=G-XXXXXXXXXX
ANALYTICS_REQUIRE_CONSENT=true
WEBSITE_SOCIAL_IMAGE=https://fida.af/path/to/a-1200x630-image.jpg
WEBSITE_SAME_AS=https://github.com/fidatech
WEBSITE_INDEXABLE=true
WEBSITE_PRODUCTION_HOST=fida.af
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
```

GA4 is not requested from the browser until the visitor accepts analytics. The public site records configured CTA clicks, product-profile visits and a `generate_lead` event after a successful project-form submission; it does not send form field values to analytics.

Generate and configure an IndexNow key, then clear the cached configuration and submit all published localized URLs:

```bash
php -r 'echo bin2hex(random_bytes(16)), PHP_EOL;'
# Add the resulting value as INDEXNOW_KEY in .env
php artisan optimize:clear
php artisan website:indexnow
```

The key is exposed only through `/indexnow-key.txt` when configured. Run the submission command after publishing or materially updating pages. Search engines decide whether and when submitted URLs are crawled or indexed.

## Production migration checklist

The currently indexed `www.fida.af` homepage must consolidate into the canonical `fida.af` host. Both the web-server rule and Laravel middleware preserve the path and query string with a `301` redirect. Keep both hostnames connected to the production account and covered by HTTPS.

Before changing the production document root:

1. Export at least the last 16 months of **Pages** data from Google Search Console, plus Bing Webmaster Tools if available. Public `site:` searches are not an exhaustive URL inventory.
2. Crawl the existing website and combine that list with the exports, backlinks and analytics landing pages.
3. For every verified legacy URL, choose the closest new equivalent and add a direct one-hop `301`; do not redirect unrelated URLs to the homepage.
4. Back up the current files, database and `.env`, then deploy the reviewed `main` commit to a fresh release directory.
5. Set `APP_URL=https://fida.af`, `APP_ENV=production`, `APP_DEBUG=false` and `WEBSITE_INDEXABLE=true`; configure the verification, analytics and IndexNow values.
6. Follow `docs/production-launch-runbook.md`: build and test with development dependencies before maintenance mode, deploy to a new release directory, then install production-only dependencies.
7. Verify HTTPS, redirects, canonical tags, robots, sitemap, localized pages, the lead form and admin login before submitting the sitemap and IndexNow URLs.
8. Monitor Search Console indexing, Page indexing, Core Web Vitals and 404 logs weekly after launch. Keep verified legacy redirects for at least one year.

Run `php artisan website:deployment-audit https://stage.fida.af --mode=staging` before cutover. After the approved production cutover, run `php artisan website:deployment-audit https://fida.af --mode=production` before submitting the sitemap or IndexNow URLs.

Search Console and Bing verification are ownership and diagnostic tools; they do not guarantee rankings. Product pages and case studies should be updated only with accurate, supportable information.

## Branch policy

Development happens on feature branches. Production changes are merged into `main` only after review and explicit approval.
