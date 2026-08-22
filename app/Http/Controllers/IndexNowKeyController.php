<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class IndexNowKeyController extends Controller
{
    public function __invoke(): Response
    {
        $key = (string) config('website.indexnow.key');

        abort_if($key === '', 404);

        return response($key)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
