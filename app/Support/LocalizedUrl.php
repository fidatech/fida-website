<?php

namespace App\Support;

use Illuminate\Support\Str;

class LocalizedUrl
{
    public static function current(string $locale): string
    {
        $path = trim(request()->path(), '/');
        $segments = $path === '' ? [] : explode('/', $path);
        $supported = array_keys(config('website.locales', []));

        if (isset($segments[0]) && in_array($segments[0], $supported, true)) {
            array_shift($segments);
        }

        $localizedPath = implode('/', $segments);

        if ($locale === config('website.default_locale')) {
            return url($localizedPath === '' ? '/' : '/'.$localizedPath);
        }

        return url('/'.$locale.($localizedPath === '' ? '' : '/'.$localizedPath));
    }

    public static function path(string $path, ?string $locale = null): string
    {
        $locale ??= app()->getLocale();
        $path = Str::start(trim($path, '/'), '/');

        if ($locale === config('website.default_locale')) {
            return url($path === '/' ? '/' : $path);
        }

        return url('/'.$locale.($path === '/' ? '' : $path));
    }
}
