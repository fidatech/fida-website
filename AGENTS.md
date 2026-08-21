# Fida Technologies Website

## Product direction

- Build a fast, premium, multilingual lead-generation and authority website for Fida Technologies.
- Preserve the existing `fida.af` ranking for “ERP Systems Afghanistan” during migration.
- Default public locale is English at `/`; Dari and Pashto use `/fa` and `/ps`.
- Public pages must remain server-rendered and usable without client-side JavaScript.
- Use real product information, case studies and screenshots. Do not invent clients, awards, testimonials or results.

## Architecture

- Laravel 13, Blade, Tailwind CSS and minimal vanilla JavaScript.
- Use Livewire only when server-driven interaction materially improves a feature.
- MySQL in production; SQLite in automated tests.
- Public content is stored as multilingual JSON fields and must fall back to English.
- Sneat is reserved for the authenticated administration interface; the public website has a custom design system.

## SEO and performance

- Every indexable page needs a unique title, description, canonical URL and localized alternate URLs.
- Preserve or redirect every previously indexed URL before production launch.
- Keep meaningful content in the initial HTML response.
- Target good Core Web Vitals: LCP <= 2.5s, INP < 200ms, CLS < 0.1.
- Avoid heavy animation, unnecessary client-side packages, stock filler content and keyword doorway pages.
- Keep `robots.txt`, XML sitemap and structured data accurate.

## Git workflow

- Never commit secrets or `.env` files.
- Develop on feature branches and never merge into `main` without Fida's explicit permission.
- Run the PHP test suite and frontend production build before publishing a milestone.
