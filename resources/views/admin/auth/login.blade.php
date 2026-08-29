<!doctype html>
@php
    $adminTheme = config('website.appearance.current_theme_values', config('website.appearance.themes.midnight'));
    $adminColors = config('website.appearance.current_colors', config('website.appearance.palettes.fida'));
    $adminRgb = config('website.appearance.rgb', ['primary' => '201,255,74', 'secondary' => '132,108,255', 'highlight' => '78,232,255']);
@endphp
<html lang="en" dir="ltr" style="--admin-bg:{{ $adminTheme['background'] }};--admin-panel:{{ $adminTheme['surface'] }};--admin-panel-soft:{{ $adminTheme['background_soft'] }};--admin-lime:{{ $adminColors['primary'] }};--admin-violet:{{ $adminColors['secondary'] }};--admin-cyan:{{ $adminColors['highlight'] }};--admin-accent-rgb:{{ $adminRgb['primary'] }};--admin-secondary-rgb:{{ $adminRgb['secondary'] }};--admin-highlight-rgb:{{ $adminRgb['highlight'] }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Secure console · {{ config('website.branding.name') }}</title>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body class="login-body">
    <main class="login-shell">
        <section class="login-visual" aria-hidden="true">
            <div class="login-grid"></div>
            <div class="login-orbit login-orbit-one"></div>
            <div class="login-orbit login-orbit-two"></div>
            <div class="login-cube">
                <span>{{ mb_substr(config('website.branding.name'), 0, 1) }}</span><i></i><b></b>
            </div>
            <div class="login-signal"><i></i> Secure administration layer</div>
            <div class="login-copy">
                <small>FIDA / CONTROL SYSTEM</small>
                <h1>Operate the website.<br><em>Move the business.</em></h1>
                <p>Content, multilingual SEO and customer opportunities in one focused workspace.</p>
            </div>
        </section>

        <section class="login-panel">
            <a class="console-brand" href="{{ route('home') }}">
                @if(config('website.branding.logo_url'))
                    <span class="console-brand-logo"><img src="{{ config('website.branding.logo_url') }}" alt=""></span>
                @else
                    <span class="console-brand-mark"><b>{{ mb_substr(config('website.branding.name'), 0, 1) }}</b></span>
                @endif
                <span><strong>{{ config('website.branding.name') }}</strong><small>website console</small></span>
            </a>
            <div class="login-form-wrap">
                <small class="form-index">01 / AUTHENTICATION</small>
                <h2>Welcome back.</h2>
                <p>Use your authorized account to continue.</p>

                <form class="console-form login-form" method="POST" action="{{ route('admin.login.store') }}">
                    @csrf
                    <label>
                        <span>Email address</span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="name@fida.af">
                        @error('email')<small class="field-error">{{ $message }}</small>@enderror
                    </label>
                    <label>
                        <span>Password</span>
                        <span class="password-field">
                            <input type="password" name="password" required autocomplete="current-password" data-password placeholder="••••••••••••">
                            <button type="button" data-password-toggle aria-label="Show password">Show</button>
                        </span>
                        @error('password')<small class="field-error">{{ $message }}</small>@enderror
                    </label>
                    <label class="checkbox-row">
                        <input type="checkbox" name="remember" value="1">
                        <span>Keep me signed in on this device</span>
                    </label>
                    <button class="console-button console-button-primary console-button-wide" type="submit">
                        Enter console <span>↗</span>
                    </button>
                </form>
            </div>
            <footer><i></i> Protected by encrypted session security</footer>
        </section>
    </main>
</body>
</html>
