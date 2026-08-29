<section class="editor-heading"><div><a href="{{ route('admin.users.index') }}">← Team & roles</a><h1>{{ $managedUser->exists ? $managedUser->name : 'New team member' }}</h1><p>Assign the minimum access needed for this person’s work.</p></div><button class="console-button console-button-primary" type="submit">{{ $submitLabel }} <span>✓</span></button></section>
<div class="user-editor-grid">
    <section class="console-card user-form-card">
        <div class="form-section-head"><span>01</span><div><h2>Account identity</h2><p>The person who will use this secure account.</p></div></div>
        <div class="console-form two-columns">
            <label><span>Full name</span><input name="name" required value="{{ old('name', $managedUser->name) }}">@error('name')<small class="field-error">{{ $message }}</small>@enderror</label>
            <label><span>Email address</span><input type="email" name="email" required value="{{ old('email', $managedUser->email) }}">@error('email')<small class="field-error">{{ $message }}</small>@enderror</label>
            <label><span>{{ $managedUser->exists ? 'New password' : 'Password' }}</span><input type="password" name="password" @required(!$managedUser->exists) autocomplete="new-password"><small>{{ $managedUser->exists ? 'Leave blank to keep the current password.' : '12+ characters with upper/lowercase letters and numbers.' }}</small></label>
            <label><span>Confirm password</span><input type="password" name="password_confirmation" @required(!$managedUser->exists) autocomplete="new-password"></label>
        </div>
    </section>
    <aside class="console-card role-form-card">
        <header><small>02 / ROLE & STATUS</small></header>
        <div class="role-options">
            @foreach(['super_admin' => ['Super administrator', 'All console areas and access control.'], 'editor' => ['Content editor', 'Pages, translations and SEO fields.'], 'sales' => ['Sales manager', 'Customer leads and opportunity pipeline.']] as $role => [$label, $description])
                <label><input type="radio" name="role" value="{{ $role }}" @checked(old('role', $managedUser->role ?: 'editor') === $role)><span><b>{{ $label }}</b><small>{{ $description }}</small></span><i>✓</i></label>
            @endforeach
        </div>
        @error('role')<small class="field-error">{{ $message }}</small>@enderror
        <label class="account-toggle"><input type="checkbox" name="active" value="1" @checked(old('active', $managedUser->exists ? $managedUser->active : true))><span><b>Account active</b><small>Allow this person to sign in.</small></span></label>
    </aside>
</div>
@if($errors->any())<section class="console-card error-list"><strong>Fix before saving</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></section>@endif
