<?php

use App\Console\Commands\AuditWebsiteDeployment;
use App\Console\Commands\AuditWebsiteRelease;
use App\Console\Commands\CreateAdminUser;
use App\Console\Commands\SubmitIndexNow;
use App\Http\Middleware\AddSecurityHeaders;
use App\Http\Middleware\EnsureAdminAccess;
use App\Http\Middleware\EnsureCapability;
use App\Http\Middleware\EnforceCanonicalHost;
use App\Http\Middleware\ApplyWebsiteSettings;
use App\Http\Middleware\RedirectLegacyUrls;
use App\Http\Middleware\ProtectNonIndexableEnvironment;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\TrackWebsiteAnalytics;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withCommands([
        AuditWebsiteDeployment::class,
        AuditWebsiteRelease::class,
        CreateAdminUser::class,
        SubmitIndexNow::class,
    ])
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(prepend: [AddSecurityHeaders::class, RedirectLegacyUrls::class]);
        $middleware->web(append: [SetLocale::class, ApplyWebsiteSettings::class, EnforceCanonicalHost::class, ProtectNonIndexableEnvironment::class, TrackWebsiteAnalytics::class]);

        $middleware->redirectGuestsTo(fn (Request $request) => route('admin.login'));
        $middleware->redirectUsersTo(fn (Request $request) => route('admin.dashboard'));

        $middleware->alias([
            'admin' => EnsureAdminAccess::class,
            'capability' => EnsureCapability::class,
            'locale' => SetLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
