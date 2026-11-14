# Insights articles published from the repository

Each `*.json` file in this folder is one Insights article. Merging a pull request that adds a
file is the editorial approval: the next production deployment runs
`php artisan website:import-insights`, which publishes the article on fida.af in English, Dari
and Pashto.

## Rules

- File name must be `<slug>.json` and match the `slug` field (lowercase kebab-case).
- `title`, `summary`, `body`, `meta_title`, `meta_description` and `primary_query` are required
  in `en`, `fa` and `ps`.
- `body` is HTML limited to `<h2> <h3> <p> <ul> <ol> <li> <strong> <em> <a>`, with at least two
  `<h2>` sections and at least 280 English words (200 for Dari and Pashto).
- Use only real Fida Technologies product and service information. Do not invent clients,
  awards, testimonials, statistics or results.
- The company name is written فدا (not فیدا) in Dari and Pashto.
- Optional fields: `eyebrow`, `category` (an active article category slug), `publish_on`
  (`YYYY-MM-DD`, published at 09:00 Asia/Kabul), `author_name`, `faqs`, `related_slugs`.
- The importer never overwrites a page that was created in the admin panel. Editing a file
  that was already imported updates that article on the next deployment.

## Shape

```json
{
  "slug": "example-article-slug",
  "category": "business-software-planning",
  "publish_on": "2026-11-12",
  "title": {"en": "", "fa": "", "ps": ""},
  "eyebrow": {"en": "", "fa": "", "ps": ""},
  "summary": {"en": "", "fa": "", "ps": ""},
  "body": {"en": "<h2>…</h2><p>…</p>", "fa": "", "ps": ""},
  "meta_title": {"en": "", "fa": "", "ps": ""},
  "meta_description": {"en": "", "fa": "", "ps": ""},
  "primary_query": {"en": "", "fa": "", "ps": ""},
  "faqs": [{"question": {"en": "", "fa": "", "ps": ""}, "answer": {"en": "", "fa": "", "ps": ""}}],
  "related_slugs": ["erp-systems-afghanistan"]
}
```

Validate locally with `php artisan website:import-insights --check`.
