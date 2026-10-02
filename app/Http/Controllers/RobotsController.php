<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class RobotsController extends Controller
{
    public function __invoke(): Response
    {
        if (! config('website.indexable')) {
            return response("User-agent: *\nDisallow: /\n")
                ->header('Content-Type', 'text/plain; charset=UTF-8');
        }

        $content = implode("\n", [
            'User-agent: *',
            'Allow: /',
            '',
            'User-agent: OAI-SearchBot',
            'Allow: /',
            '',
            'User-agent: GPTBot',
            'Allow: /',
            '',
            'User-agent: ClaudeBot',
            'Allow: /',
            '',
            'User-agent: PerplexityBot',
            'Allow: /',
            '',
            'User-agent: Applebot',
            'Allow: /',
            '',
            'Sitemap: '.route('sitemap'),
            'Host: '.config('website.production_host'),
            '',
        ]);

        return response($content)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
