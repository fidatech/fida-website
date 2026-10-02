@extends('layouts.admin')

@section('title', 'Brand & settings')
@section('eyebrow', 'Control / public identity')

@section('content')
    <form action="{{ route('admin.settings.update') }}" method="post" enctype="multipart/form-data" data-settings-form>
        @csrf
        @method('PUT')

        <section class="editor-heading settings-heading">
            <div>
                <small class="section-code">WEBSITE CONTROL</small>
                <h1>Your identity, from one place.</h1>
                <p>Manage company details, the public logo, surface theme and color system.</p>
            </div>
            <div class="editor-actions">
                <a class="console-button console-button-quiet" href="{{ route('home') }}" target="_blank" rel="noopener">Preview website ↗</a>
                <button class="console-button console-button-primary" type="submit">Save settings <span>✓</span></button>
            </div>
        </section>

        <div class="website-settings-layout">
            <div class="website-settings-main">
                <section class="console-card settings-panel brand-settings-panel">
                    <header>
                        <div><small>BRAND IDENTITY</small><h2>Logo and signature</h2></div>
                        <span class="settings-state">PUBLIC</span>
                    </header>
                    <div class="settings-panel-body brand-settings-grid">
                        <div class="logo-uploader">
                            <div class="logo-preview" data-logo-preview>
                                @if(config('website.branding.logo_url'))
                                    <img src="{{ config('website.branding.logo_url') }}" alt="Current company logo">
                                @else
                                    <span data-logo-fallback>{{ mb_substr($settings['brand_name'], 0, 1) }}</span>
                                @endif
                            </div>
                            <div>
                                <strong>Company logo</strong>
                                <p>PNG, JPG or WebP. Use a transparent image when possible; maximum 2 MB.</p>
                                <label class="file-button"><input type="file" name="logo" accept="image/png,image/jpeg,image/webp" data-logo-input><span>Choose image</span></label>
                                @if($settings['logo_path'])
                                    <label class="remove-logo"><input type="checkbox" name="remove_logo" value="1"><span>Remove current logo</span></label>
                                @else
                                    <input type="hidden" name="remove_logo" value="0">
                                @endif
                                @error('logo')<small class="field-error">{{ $message }}</small>@enderror
                            </div>
                        </div>

                        <div class="console-form two-columns">
                            <label><span>Brand name <b>Header</b></span><input name="brand_name" maxlength="80" required value="{{ old('brand_name', $settings['brand_name']) }}" data-brand-name></label>
                            <label><span>Brand tagline <b>Header</b></span><input name="brand_tagline" maxlength="80" required value="{{ old('brand_tagline', $settings['brand_tagline']) }}" data-brand-tagline></label>
                        </div>

                        <div class="brand-live-preview">
                            <small>LIVE BRAND PREVIEW</small>
                            <div>
                                <span class="preview-mark" data-brand-mark-preview>{{ mb_substr($settings['brand_name'], 0, 1) }}</span>
                                <span><strong data-brand-name-preview>{{ old('brand_name', $settings['brand_name']) }}</strong><small data-brand-tagline-preview>{{ old('brand_tagline', $settings['brand_tagline']) }}</small></span>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="console-card settings-panel appearance-panel">
                    <header>
                        <div><small>SURFACE THEME</small><h2>Choose the atmosphere</h2></div>
                        <span class="settings-state">3 OPTIONS</span>
                    </header>
                    <div class="settings-panel-body">
                        <div class="theme-options" data-theme-options>
                            @foreach($themes as $key => $theme)
                                <label class="theme-option" style="--preview-bg: {{ $theme['background'] }}; --preview-soft: {{ $theme['background_soft'] }}; --preview-surface: {{ $theme['surface'] }}">
                                    <input type="radio" name="theme" value="{{ $key }}" @checked(old('theme', $settings['theme']) === $key)>
                                    <span class="theme-visual"><i></i><i></i><i></i></span>
                                    <span class="theme-copy"><b>{{ $theme['label'] }}</b><small>{{ $theme['description'] }}</small></span>
                                    <em>✓</em>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </section>

                <section class="console-card settings-panel palette-panel">
                    <header>
                        <div><small>COLOR SYSTEM</small><h2>Select the energy</h2></div>
                        <span class="settings-state">LIVE ACCENT</span>
                    </header>
                    <div class="settings-panel-body">
                        <div class="palette-options" data-palette-options>
                            @foreach($palettes as $key => $palette)
                                <label class="palette-option" data-palette-card data-primary="{{ $palette['primary'] }}" data-secondary="{{ $palette['secondary'] }}" data-highlight="{{ $palette['highlight'] }}">
                                    <input type="radio" name="palette" value="{{ $key }}" @checked(old('palette', $settings['palette']) === $key)>
                                    <span class="palette-swatches"><i style="background:{{ $palette['primary'] }}"></i><i style="background:{{ $palette['secondary'] }}"></i><i style="background:{{ $palette['highlight'] }}"></i></span>
                                    <span><b>{{ $palette['label'] }}</b><small>{{ $palette['description'] }}</small></span>
                                    <em>✓</em>
                                </label>
                            @endforeach
                            <label class="palette-option palette-custom-option" data-palette-card>
                                <input type="radio" name="palette" value="custom" @checked(old('palette', $settings['palette']) === 'custom')>
                                <span class="palette-swatches custom"><i></i><i></i><i></i></span>
                                <span><b>Custom palette</b><small>Define three controlled accent colors.</small></span>
                                <em>✓</em>
                            </label>
                        </div>

                        <div class="custom-color-lab" data-custom-colors>
                            <div><small>CUSTOM COLOR LAB</small><strong>Fine-tune the accents</strong></div>
                            <label><span>Primary</span><input type="color" name="primary_color" value="{{ old('primary_color', $settings['primary_color']) }}" data-color-input="primary"><code data-color-code="primary">{{ old('primary_color', $settings['primary_color']) }}</code></label>
                            <label><span>Secondary</span><input type="color" name="secondary_color" value="{{ old('secondary_color', $settings['secondary_color']) }}" data-color-input="secondary"><code data-color-code="secondary">{{ old('secondary_color', $settings['secondary_color']) }}</code></label>
                            <label><span>Highlight</span><input type="color" name="highlight_color" value="{{ old('highlight_color', $settings['highlight_color']) }}" data-color-input="highlight"><code data-color-code="highlight">{{ old('highlight_color', $settings['highlight_color']) }}</code></label>
                        </div>
                    </div>
                </section>
            </div>

            <aside class="website-settings-side">
                <section class="console-card settings-panel company-settings-panel">
                    <header><div><small>COMPANY PROFILE</small><h2>Public information</h2></div></header>
                    <div class="settings-panel-body console-form">
                        <label><span>Company name</span><input name="company_name" maxlength="160" required value="{{ old('company_name', $settings['company_name']) }}"></label>
                        <label><span>Legal name</span><input name="legal_name" maxlength="190" required value="{{ old('legal_name', $settings['legal_name']) }}"></label>
                        <label><span>Email address</span><input type="email" name="email" maxlength="190" required value="{{ old('email', $settings['email']) }}"></label>
                        <label><span>Phone number</span><input name="phone" maxlength="50" required value="{{ old('phone', $settings['phone']) }}" dir="ltr"></label>
                        <label><span>WhatsApp number <b>Digits only</b></span><input name="whatsapp" maxlength="30" required value="{{ old('whatsapp', $settings['whatsapp']) }}" dir="ltr"></label>
                        <label><span>Street / office address</span><textarea name="address_line" rows="3" maxlength="255">{{ old('address_line', $settings['address_line']) }}</textarea></label>
                        <div class="console-form two-columns compact-fields">
                            <label><span>City</span><input name="city" maxlength="100" required value="{{ old('city', $settings['city']) }}"></label>
                            <label><span>Country</span><input name="country" maxlength="100" required value="{{ old('country', $settings['country']) }}"></label>
                        </div>
                        <label><span>Country code <b>ISO 2</b></span><input name="country_code" maxlength="2" required value="{{ old('country_code', $settings['country_code']) }}" style="text-transform:uppercase"></label>
                        <label><span>Map embed URL</span><textarea name="map_embed_url" rows="4" maxlength="2048" dir="ltr" placeholder="https://www.google.com/maps/embed?...">{{ old('map_embed_url', $settings['map_embed_url']) }}</textarea><small>Paste the HTTPS embed URL from Google Maps or OpenStreetMap—not custom iframe code.</small></label>
                    </div>
                </section>

                <section class="console-card settings-panel lead-notification-panel">
                    <header>
                        <div><small>LEAD NOTIFICATIONS</small><h2>Instant lead alerts</h2></div>
                        <span class="settings-state">{{ $leadNotificationSettings['email_enabled'] ? 'EMAIL ON' : 'EMAIL OFF' }}</span>
                    </header>
                    <div class="settings-panel-body console-form">
                        <p class="settings-help">Send an immediate email whenever a new lead is submitted from the website, so you do not need to check the admin panel every day.</p>
                        <input type="hidden" name="lead_email_enabled" value="0">
                        <label class="checkbox-row">
                            <input type="checkbox" name="lead_email_enabled" value="1" @checked(old('lead_email_enabled', $leadNotificationSettings['email_enabled']))>
                            <span>Send email for every new website lead</span>
                        </label>
                        <label>
                            <span>Notification email</span>
                            <input type="email" name="lead_email_recipient" maxlength="190" value="{{ old('lead_email_recipient', $leadNotificationSettings['email_recipient']) }}" placeholder="{{ $settings['email'] }}">
                            <small>The email includes the lead details, source page, and a direct link to the lead in admin.</small>
                        </label>
                        <div class="ai-provider-note">
                            <strong>WhatsApp option</strong>
                            <p>For automatic WhatsApp alerts, use the official WhatsApp Business Cloud API. It needs a business number, access token and an approved notification template. Email is enabled first because it works without another paid messaging provider.</p>
                        </div>
                    </div>
                </section>

                <section class="console-card settings-panel ai-settings-panel">
                    <header>
                        <div><small>AI ASSISTANT</small><h2>Growth advisor</h2></div>
                        <span class="settings-state">{{ $aiSettings['has_api_key'] ? 'CONNECTED' : 'NOT CONNECTED' }}</span>
                    </header>
                    <div class="settings-panel-body console-form">
                        <p class="settings-help">Used only from the private Analytics page to turn aggregated visitor and Search Console data into ERP, content and conversion recommendations. The API key is encrypted before it is stored.</p>
                        <label>
                            <span>Provider</span>
                            <select name="ai_provider" data-ai-provider>
                                <option value="gemini" @selected(old('ai_provider', $aiSettings['provider']) === 'gemini')>Google Gemini</option>
                                <option value="openrouter" @selected(old('ai_provider', $aiSettings['provider']) === 'openrouter')>OpenRouter</option>
                            </select>
                        </label>
                        <label>
                            <span>Model</span>
                            <input name="ai_model" maxlength="120" value="{{ old('ai_model', $aiSettings['model']) }}" placeholder="gemini-3.8-flash" required>
                            <small>Recommended starting point: Gemini 3.8 Flash. For OpenRouter you can use a free model ID or <code>openrouter/free</code>.</small>
                        </label>
                        <label>
                            <span>API key @if($aiSettings['has_api_key'])<b>Configured</b>@endif</span>
                            <input type="password" name="ai_api_key" maxlength="500" autocomplete="new-password" placeholder="{{ $aiSettings['has_api_key'] ? 'Leave blank to keep the current key' : 'Paste API key' }}">
                            <small>The saved key is never shown back in the admin panel.</small>
                        </label>
                        @if($aiSettings['has_api_key'])
                            <label class="checkbox-row">
                                <input type="checkbox" name="remove_ai_api_key" value="1">
                                <span>Remove the saved AI API key</span>
                            </label>
                        @else
                            <input type="hidden" name="remove_ai_api_key" value="0">
                        @endif
                        <div class="ai-provider-note">
                            <strong>Free option</strong>
                            <p>Gemini has a developer free tier for supported models. OpenRouter is useful when you want one key for multiple free models, but its free plan has a lower daily request allowance.</p>
                        </div>
                    </div>
                </section>

                <section class="settings-security-note">
                    <span>◎</span>
                    <div><strong>Safe by design</strong><p>Uploaded logos are restricted to image formats. Themes use validated presets and color values; map embeds accept approved providers only.</p></div>
                </section>
            </aside>
        </div>

        @if($errors->any())
            <section class="console-card error-list settings-errors"><strong>Fix before saving</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></section>
        @endif
    </form>
@endsection
