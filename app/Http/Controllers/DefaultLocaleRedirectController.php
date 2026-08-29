<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultLocaleRedirectController extends Controller
{
    public function __invoke(Request $request, string $defaultLocale, ?string $path = null): RedirectResponse
    {
        $target = rtrim((string) config('website.url'), '/');
        $target .= filled($path) ? '/'.ltrim((string) $path, '/') : '/';

        if ($request->getQueryString()) {
            $target .= '?'.$request->getQueryString();
        }

        return redirect()->away($target, Response::HTTP_MOVED_PERMANENTLY);
    }
}
