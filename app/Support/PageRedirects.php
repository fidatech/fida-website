<?php

namespace App\Support;

use App\Models\PageRedirect;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

final class PageRedirects
{
    public function rememberSlugChange(string $oldSlug, string $newSlug): void
    {
        if ($oldSlug === $newSlug) {
            return;
        }

        DB::transaction(function () use ($oldSlug, $newSlug): void {
            foreach (array_keys(config('website.locales')) as $locale) {
                $prefix = $locale === config('website.default_locale') ? '' : '/'.$locale;
                $sourcePath = self::normalize($prefix.'/'.$oldSlug);
                $targetPath = self::normalize($prefix.'/'.$newSlug);

                // A slug may be changed back to an earlier value. That earlier
                // path becomes canonical again, so its historical redirect must go.
                PageRedirect::query()->where('source_path', $targetPath)->delete();
                PageRedirect::query()->where('target_path', $sourcePath)->update(['target_path' => $targetPath]);

                $this->upsert($sourcePath, $targetPath);
            }
        });
    }

    public function upsert(string $sourcePath, string $targetPath, int $statusCode = 301, bool $active = true): PageRedirect
    {
        $sourcePath = self::normalize($sourcePath);
        $targetPath = self::normalize($targetPath);

        if ($sourcePath === $targetPath) {
            throw new InvalidArgumentException('Redirect source and target must be different.');
        }

        $targetPath = $this->finalTarget($sourcePath, $targetPath);

        PageRedirect::query()
            ->where('target_path', $sourcePath)
            ->update(['target_path' => $targetPath]);

        return PageRedirect::query()->updateOrCreate(
            ['source_path' => $sourcePath],
            [
                'target_path' => $targetPath,
                'status_code' => $statusCode,
                'active' => $active,
            ],
        );
    }

    public static function normalize(string $path): string
    {
        $path = '/'.ltrim(trim($path), '/');
        $path = preg_replace('#/+#', '/', $path) ?: '/';

        return $path === '/' ? '/' : rtrim($path, '/');
    }

    private function finalTarget(string $sourcePath, string $targetPath): string
    {
        $visited = [$sourcePath => true];
        $cursor = $targetPath;

        for ($depth = 0; $depth < 20; $depth++) {
            if (isset($visited[$cursor])) {
                throw new InvalidArgumentException('This redirect would create a loop.');
            }

            $visited[$cursor] = true;
            $next = PageRedirect::query()
                ->where('source_path', $cursor)
                ->where('active', true)
                ->value('target_path');

            if (! is_string($next) || $next === '') {
                return $cursor;
            }

            $cursor = self::normalize($next);
        }

        throw new InvalidArgumentException('The redirect chain is too deep.');
    }
}
