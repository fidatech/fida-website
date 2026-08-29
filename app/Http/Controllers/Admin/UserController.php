<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::query()->whereNotNull('role')->orderBy('name')->paginate(25),
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create', ['managedUser' => new User]);
    }

    public function store(UserRequest $request): RedirectResponse
    {
        $user = User::query()->create($request->validated());

        return redirect()->route('admin.users.edit', $user)->with('success', 'Team member created.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', ['managedUser' => $user]);
    }

    public function update(UserRequest $request, User $user): RedirectResponse
    {
        $data = $request->validated();

        if ($request->user()->is($user) && (! $data['active'] || $data['role'] !== 'super_admin')) {
            return back()->withErrors(['role' => 'You cannot remove or deactivate your own super administrator access.']);
        }

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return back()->with('success', 'Team member updated.');
    }
}
