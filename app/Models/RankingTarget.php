<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RankingTarget extends Model
{
    protected $fillable = ['keyword', 'locale', 'target_url', 'target_position', 'active', 'notes'];

    protected function casts(): array
    {
        return ['target_position' => 'decimal:2', 'active' => 'boolean'];
    }
}
