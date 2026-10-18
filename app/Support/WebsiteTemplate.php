<?php

namespace App\Support;

use Illuminate\Http\Request;

final class WebsiteTemplate
{
    public static function resolve(Request $request): string
    {
        $templates = config('website.appearance.templates', []);
        $selected = (string) config('website.appearance.current_template', config('website.appearance.default_template', 'technology'));

        // Unpublished previews are available only to authenticated settings administrators.
        $preview = $request->query('template_preview');
        if (is_string($preview)
            && array_key_exists($preview, $templates)
            && $request->user()?->allows('settings.manage') === true) {
            return $preview;
        }

        return array_key_exists($selected, $templates) ? $selected : 'technology';
    }

    public static function isAuthorizedPreview(Request $request): bool
    {
        return is_string($request->query('template_preview'))
            && array_key_exists($request->query('template_preview'), config('website.appearance.templates', []))
            && $request->user()?->allows('settings.manage') === true;
    }
}
