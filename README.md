# Fida Technologies Website

Official multilingual website and lead-generation platform for [Fida Technologies](https://fida.af).

## Foundation

- Laravel 13 with server-rendered Blade pages
- Tailwind CSS 4 and minimal JavaScript
- English, Dari and Pashto with RTL support
- Dynamic multilingual landing-page content
- Search metadata, canonical URLs, hreflang, XML sitemap and page-specific structured data
- Visible multilingual FAQs, service entities, breadcrumbs and related-topic internal links
- Google and Bing ownership verification hooks, OpenAI crawler policy and IndexNow submission
- Lead capture with campaign attribution and spam protection
- Automated PHP tests and frontend build verification
- Separate authenticated website console for content, leads and team access

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
WEBSITE_SOCIAL_IMAGE=https://fida.af/path/to/a-1200x630-image.jpg
WEBSITE_INDEXABLE=true
```

Generate and configure an IndexNow key, then clear the cached configuration and submit all published localized URLs:

```bash
php -r 'echo bin2hex(random_bytes(16)), PHP_EOL;'
# Add the resulting value as INDEXNOW_KEY in .env
php artisan optimize:clear
php artisan website:indexnow
```

The key is exposed only through `/indexnow-key.txt` when configured. Run the submission command after publishing or materially updating pages. Search engines decide whether and when submitted URLs are crawled or indexed.

## Branch policy

Development happens on feature branches. Production changes are merged into `main` only after review and explicit approval.
