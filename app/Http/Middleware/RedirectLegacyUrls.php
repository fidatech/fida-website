<?php

namespace App\Http\Middleware;

use App\Models\PageRedirect;
use App\Support\PageRedirects;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectLegacyUrls
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! in_array($request->method(), ['GET', 'HEAD'], true) || $request->is('admin', 'admin/*', 'up')) {
            return $next($request);
        }

        $sourcePath = PageRedirects::normalize('/'.$request->path());
        $redirect = PageRedirect::query()
            ->where('source_path', $sourcePath)
            ->where('active', true)
            ->first();

        if (! $redirect) {
            return $next($request);
        }

        $redirect->increment('hits');
        $redirect->forceFill(['last_hit_at' => now()])->save();

        $target = rtrim((string) config('website.url'), '/').$redirect->target_path;

        if ($request->getQueryString()) {
            $target .= '?'.$request->getQueryString();
        }

        return redirect()->away($target, $redirect->status_code);
    }
}
