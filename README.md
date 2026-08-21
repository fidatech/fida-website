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

Run the verification suite:

```bash
php artisan test
npm run build
```

## Branch policy

Development happens on feature branches. Production changes are merged into `main` only after review and explicit approval.
