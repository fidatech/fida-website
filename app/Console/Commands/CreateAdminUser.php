<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class CreateAdminUser extends Command
{
    protected $signature = 'website:make-admin {email? : Administrator email address}';

    protected $description = 'Create or promote a secure Fida website administrator';

    public function handle(): int
    {
        $email = $this->argument('email') ?: $this->ask('Email address');
        $name = $this->ask('Full name');
        $role = $this->choice('Role', ['super_admin', 'editor', 'sales'], 0);
        $password = $this->secret('Password (12+ characters)');
        $confirmation = $this->secret('Confirm password');

        try {
            $data = validator([
                'email' => $email,
                'name' => $name,
                'role' => $role,
                'password' => $password,
                'password_confirmation' => $confirmation,
            ], [
                'email' => ['required', 'email', 'max:190'],
                'name' => ['required', 'string', 'max:120'],
                'role' => ['required', Rule::in(['super_admin', 'editor', 'sales'])],
                'password' => ['required', 'confirmed', Password::min(12)->letters()->mixedCase()->numbers()],
            ])->validate();
        } catch (ValidationException $exception) {
            foreach ($exception->errors() as $messages) {
                foreach ($messages as $message) {
                    $this->error($message);
                }
            }

            return self::FAILURE;
        }

        $user = User::query()->firstOrNew(['email' => $data['email']]);
        $user->fill([
            'name' => $data['name'],
            'role' => $data['role'],
            'active' => true,
            'password' => Hash::make($data['password']),
        ])->save();

        $this->info("Admin access is ready for {$user->email}.");

        return self::SUCCESS;
    }
}
