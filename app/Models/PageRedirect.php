<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageRedirect extends Model
{
    protected $fillable = [
        'source_path',
        'target_path',
        'status_code',
        'active',
        'hits',
        'last_hit_at',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'hits' => 'integer',
            'last_hit_at' => 'datetime',
        ];
    }
}
