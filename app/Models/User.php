<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'active', 'last_login_at'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'active' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->active && in_array($this->role, ['super_admin', 'editor', 'sales'], true);
    }

    public function allows(string $capability): bool
    {
        if (! $this->isAdmin()) {
            return false;
        }

        return match ($this->role) {
            'super_admin' => true,
            'editor' => $capability === 'content.manage',
            'sales' => $capability === 'leads.manage',
            default => false,
        };
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            'super_admin' => 'Super administrator',
            'editor' => 'Content editor',
            'sales' => 'Sales manager',
            default => 'No admin access',
        };
    }
}
