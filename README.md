# Fida Technologies Website

Official multilingual website and lead-generation platform for [Fida Technologies](https://fida.af).

## Foundation

- Laravel 13 with server-rendered Blade pages
- Tailwind CSS 4 and minimal JavaScript
- English, Dari and Pashto with RTL support
- Dynamic multilingual landing-page content
- Search metadata, canonical URLs, hreflang, XML sitemap and Organization schema
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

## Branch policy

Development happens on feature branches. Production changes are merged into `main` only after review and explicit approval.
