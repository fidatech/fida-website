<!doctype html>
@php
    $adminTheme = config('website.admin_appearance.current_theme_values', config('website.appearance.themes.midnight'));
    $adminColors = config('website.admin_appearance.current_colors', config('website.appearance.palettes.fida'));
    $adminRgb = config('website.admin_appearance.rgb', ['primary' => '201,255,74', 'secondary' => '132,108,255', 'highlight' => '78,232,255']);
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
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
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
                    @php($contentNavOpen = request()->routeIs('admin.content-pages.*') || request()->routeIs('admin.article-categories.*') || request()->routeIs('admin.article-authors.*') || request()->routeIs('admin.redirects.*'))
                    <div class="console-nav-group @if($contentNavOpen) open @endif" data-nav-group>
                        <button type="button" class="console-nav-group-toggle @if($contentNavOpen) active @endif" data-nav-group-toggle aria-expanded="{{ $contentNavOpen ? 'true' : 'false' }}">
                            <svg viewBox="0 0 24 24"><path d="M6 3h8l4 4v14H6V3Zm7 1.5V8h3.5M9 12h6M9 16h6"/></svg>
                            <span>Content</span>
                            <svg class="nav-chevron" viewBox="0 0 24 24"><path d="m8 10 4 4 4-4"/></svg>
                        </button>
                        <div class="console-nav-submenu" data-nav-group-menu>
                            <a @class(['active' => request()->routeIs('admin.content-pages.*') && !$adminActiveContentType]) href="{{ route('admin.content-pages.index') }}">All content</a>
                            @foreach(config('website.content_types') as $type => $definition)
                                <a @class(['active' => request()->routeIs('admin.content-pages.*') && $adminActiveContentType === $type]) href="{{ route('admin.content-pages.index', ['type' => $type]) }}">{{ $definition['label'] }}</a>
                            @endforeach
                            <div class="console-nav-submenu-divider"></div>
                            <a @class(['active' => request()->routeIs('admin.article-categories.*')]) href="{{ route('admin.article-categories.index') }}">Insight categories</a>
                            <a @class(['active' => request()->routeIs('admin.article-authors.*')]) href="{{ route('admin.article-authors.index') }}">Insight authors</a>
                            <a @class(['active' => request()->routeIs('admin.redirects.*')]) href="{{ route('admin.redirects.index') }}">Redirects</a>
                        </div>
                    </div>
                @endif
                @if(auth()->user()->allows('analytics.view'))
                    <a @class(['active' => request()->routeIs('admin.analytics.*')]) href="{{ route('admin.analytics.index') }}">
                        <svg viewBox="0 0 24 24"><path d="M4 19V9m5 10V5m5 14v-7m5 7V3"/><path d="M3 21h18"/></svg>
                        Analytics
                    </a>
                @endif

                @if(auth()->user()->allows('growth.manage'))
                    @php($growthNavOpen = request()->routeIs('admin.auto-articles.*') || request()->routeIs('admin.case-studies.*') || request()->routeIs('admin.rankings.*'))
                    <div class="console-nav-group @if($growthNavOpen) open @endif" data-nav-group>
                        <button type="button" class="console-nav-group-toggle @if($growthNavOpen) active @endif" data-nav-group-toggle aria-expanded="{{ $growthNavOpen ? 'true' : 'false' }}">
                            <svg viewBox="0 0 24 24"><path d="M4 18 10 12l4 4 6-9"/><path d="M15 7h5v5"/></svg>
                            <span>Growth</span>
                            <svg class="nav-chevron" viewBox="0 0 24 24"><path d="m8 10 4 4 4-4"/></svg>
                        </button>
                        <div class="console-nav-submenu" data-nav-group-menu>
                            <a @class(['active' => request()->routeIs('admin.auto-articles.*')]) href="{{ route('admin.auto-articles.index') }}">Auto articles</a>
                            <a @class(['active' => request()->routeIs('admin.case-studies.*')]) href="{{ route('admin.case-studies.index') }}">Case study studio</a>
                            <a @class(['active' => request()->routeIs('admin.rankings.*')]) href="{{ route('admin.rankings.index') }}">Ranking monitor</a>
                        </div>
                    </div>
                @endif

                @if(auth()->user()->allows('projects.manage') || auth()->user()->allows('crm.manage'))
                    @php($crmNavOpen = request()->routeIs('admin.clients.*') || request()->routeIs('admin.contracts.*') || request()->routeIs('admin.projects.*'))
                    <div class="console-nav-group @if($crmNavOpen) open @endif" data-nav-group>
                        <button type="button" class="console-nav-group-toggle @if($crmNavOpen) active @endif" data-nav-group-toggle aria-expanded="{{ $crmNavOpen ? 'true' : 'false' }}">
                            <svg viewBox="0 0 24 24"><path d="M4 7h16v12H4V7Zm4-3h8v3H8V4Z"/><path d="M9 12h6"/></svg>
                            <span>Portfolio & CRM</span>
                            <svg class="nav-chevron" viewBox="0 0 24 24"><path d="m8 10 4 4 4-4"/></svg>
                        </button>
                        <div class="console-nav-submenu" data-nav-group-menu>
                            @if(auth()->user()->allows('projects.manage'))<a @class(['active' => request()->routeIs('admin.projects.*')]) href="{{ route('admin.projects.index') }}">Projects & screenshots</a>@endif
                            @if(auth()->user()->allows('crm.manage'))<a @class(['active' => request()->routeIs('admin.clients.*')]) href="{{ route('admin.clients.index') }}">Clients</a>@endif
                            @if(auth()->user()->allows('crm.manage'))<a @class(['active' => request()->routeIs('admin.contracts.*')]) href="{{ route('admin.contracts.index') }}">Contracts</a>@endif
                        </div>
                    </div>
                @endif

                @if(auth()->user()->allows('leads.manage'))
                    <a @class(['active' => request()->routeIs('admin.leads.*')]) href="{{ route('admin.leads.index') }}">
                        <svg viewBox="0 0 24 24"><path d="M4 5h16v14H4V5Zm0 3 8 5 8-5"/></svg>
                        Leads
                        @php($consoleNewLeads = \App\Models\Lead::query()->where('status', 'new')->count())
                        @if($consoleNewLeads)<b class="nav-count">{{ $consoleNewLeads }}</b>@endif
                    </a>
                    <a @class(['active' => request()->routeIs('admin.rfqs.*')]) href="{{ route('admin.rfqs.index') }}">
                        <svg viewBox="0 0 24 24"><path d="M5 3h10l4 4v14H5V3Z"/><path d="M15 3v5h5M8 12h8M8 16h6"/></svg>
                        RFQs & tenders
                        @php($consoleNewRfqs = \App\Models\Rfq::query()->where('status', 'new')->count())
                        @if($consoleNewRfqs)<b class="nav-count">{{ $consoleNewRfqs }}</b>@endif
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
