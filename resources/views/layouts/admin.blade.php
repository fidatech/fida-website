<!doctype html>
@php
    $adminTheme = config('website.appearance.current_theme_values', config('website.appearance.themes.midnight'));
    $adminColors = config('website.appearance.current_colors', config('website.appearance.palettes.fida'));
    $adminRgb = config('website.appearance.rgb', ['primary' => '201,255,74', 'secondary' => '132,108,255', 'highlight' => '78,232,255']);
    $adminRouteContent = request()->route('contentPage');
    $adminActiveContentType = request('type') ?: ($adminRouteContent instanceof \App\Models\ContentPage ? $adminRouteContent->type : null);
@endphp
<html lang="en" dir="ltr" style="--admin-bg:{{ $adminTheme['background'] }};--admin-panel:{{ $adminTheme['surface'] }};--admin-panel-soft:{{ $adminTheme['background_soft'] }};--admin-lime:{{ $adminColors['primary'] }};--admin-violet:{{ $adminColors['secondary'] }};--admin-cyan:{{ $adminColors['highlight'] }};--admin-accent-rgb:{{ $adminRgb['primary'] }};--admin-secondary-rgb:{{ $adminRgb['secondary'] }};--admin-highlight-rgb:{{ $adminRgb['highlight'] }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Console') · {{ config('website.branding.name') }}</title>
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body class="console-body">
    <div class="console-grid">
        <aside class="console-sidebar" data-sidebar>
            <a class="console-brand" href="{{ route('admin.dashboard') }}" aria-label="{{ config('website.branding.name') }} console home">
                @if(config('website.branding.logo_url'))
                    <span class="console-brand-logo"><img src="{{ config('website.branding.logo_url') }}" alt=""></span>
                @else
                    <span class="console-brand-mark"><b>{{ mb_substr(config('website.branding.name'), 0, 1) }}</b></span>
                @endif
                <span><strong>{{ config('website.branding.name') }}</strong><small>website console</small></span>
            </a>

            <nav class="console-nav" aria-label="Administration">
                <small>Workspace</small>
                <a @class(['active' => request()->routeIs('admin.dashboard')]) href="{{ route('admin.dashboard') }}">
                    <svg viewBox="0 0 24 24"><path d="M4 13h6V4H4v9Zm0 7h6v-4H4v4Zm10 0h6v-9h-6v9Zm0-16v4h6V4h-6Z"/></svg>
                    Dashboard
                </a>
                @if(auth()->user()->allows('content.manage'))
                    <a @class(['active' => request()->routeIs('admin.content-pages.*') && !$adminActiveContentType]) href="{{ route('admin.content-pages.index') }}">
                        <svg viewBox="0 0 24 24"><path d="M6 3h8l4 4v14H6V3Zm7 1.5V8h3.5M9 12h6M9 16h6"/></svg>
                        All content
                    </a>
                    <div class="console-content-nav" aria-label="Content types">
                        @foreach(config('website.content_types') as $type => $definition)
                            <a @class(['active' => request()->routeIs('admin.content-pages.*') && $adminActiveContentType === $type]) href="{{ route('admin.content-pages.index', ['type' => $type]) }}">
                                <span>{{ strtoupper(substr($type, 0, 2)) }}</span>{{ $definition['label'] }}
                            </a>
                        @endforeach
                    </div>
                    <a @class(['active' => request()->routeIs('admin.article-categories.*')]) href="{{ route('admin.article-categories.index') }}">
                        <svg viewBox="0 0 24 24"><path d="M4 6h16M4 12h10M4 18h7"/></svg>
                        Insight categories
                    </a>
                    <a @class(['active' => request()->routeIs('admin.article-authors.*')]) href="{{ route('admin.article-authors.index') }}">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21a8 8 0 0 1 16 0"/></svg>
                        Insight authors
                    </a>
                    <a @class(['active' => request()->routeIs('admin.redirects.*')]) href="{{ route('admin.redirects.index') }}">
                        <svg viewBox="0 0 24 24"><path d="M8 7h8a4 4 0 0 1 4 4v2M16 17H8a4 4 0 0 1-4-4v-2m12 3 4-1 1 4M8 10 4 11 3 7"/></svg>
                        Redirects
                    </a>
                @endif
                @if(auth()->user()->allows('leads.manage'))
                    <a @class(['active' => request()->routeIs('admin.leads.*')]) href="{{ route('admin.leads.index') }}">
                        <svg viewBox="0 0 24 24"><path d="M4 5h16v14H4V5Zm0 3 8 5 8-5"/></svg>
                        Leads
                        @php($consoleNewLeads = \App\Models\Lead::query()->where('status', 'new')->count())
                        @if($consoleNewLeads)<b class="nav-count">{{ $consoleNewLeads }}</b>@endif
                    </a>
                @endif

                @if(auth()->user()->allows('users.manage'))
                    <small>Control</small>
                    <a @class(['active' => request()->routeIs('admin.users.*')]) href="{{ route('admin.users.index') }}">
                        <svg viewBox="0 0 24 24"><path d="M16 20v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2m6.5-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM17 8v6m-3-3h6"/></svg>
                        Team & roles
                    </a>
                @endif
                @if(auth()->user()->allows('settings.manage'))
                    <a @class(['active' => request()->routeIs('admin.settings.*')]) href="{{ route('admin.settings.edit') }}">
                        <svg viewBox="0 0 24 24"><path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm7-3.5 2-1-2-3.5-2.2.2-1.3-.8-.8-2.1H9.3L8.5 6.9l-1.3.8L5 7.5 3 11l2 1v1.8l-2 1 2 3.5 2.2-.2 1.3.8.8 2.1h5.4l.8-2.1 1.3-.8 2.2.2 2-3.5-2-1V12Z"/></svg>
                        Brand & settings
                    </a>
                @endif
            </nav>

            <div class="console-sidebar-foot">
                <span class="system-live"><i></i> System operational</span>
                <small>FIDA OS / v1.0</small>
            </div>
        </aside>

        <div class="console-stage">
            <header class="console-topbar">
                <button class="icon-button sidebar-button" type="button" data-sidebar-toggle aria-label="Toggle navigation">
                    <svg viewBox="0 0 24 24"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                </button>
                <div class="console-heading">
                    <small>@yield('eyebrow', 'Fida website')</small>
                    <strong>@yield('title', 'Console')</strong>
                </div>
                <div class="topbar-actions">
                    <a class="visit-site" href="{{ route('home') }}" target="_blank" rel="noopener">
                        <i></i> Live website
                        <svg viewBox="0 0 24 24"><path d="M7 17 17 7M9 7h8v8"/></svg>
                    </a>
                    <div class="profile-menu" data-profile-menu>
                        <button type="button" data-profile-toggle aria-expanded="false">
                            <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            <b>{{ auth()->user()->name }}</b>
                            <svg viewBox="0 0 24 24"><path d="m8 10 4 4 4-4"/></svg>
                        </button>
                        <div class="profile-dropdown">
                            <small>{{ auth()->user()->roleLabel() }}</small>
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit">Sign out</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <main class="console-content">
                @if(session('success'))
                    <div class="flash flash-success" role="status"><i></i>{{ session('success') }}<button type="button" data-dismiss>&times;</button></div>
                @endif
                @if($errors->any())
                    <div class="flash flash-error" role="alert"><i></i>Please review the highlighted fields.<button type="button" data-dismiss>&times;</button></div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    <button class="sidebar-scrim" type="button" data-sidebar-scrim aria-label="Close navigation"></button>
</body>
</html>
