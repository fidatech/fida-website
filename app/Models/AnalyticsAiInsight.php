<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticsAiInsight extends Model
{
    protected $fillable = ['provider', 'model', 'content', 'input_summary', 'generated_by'];

    protected function casts(): array
    {
        return ['input_summary' => 'array'];
    }
}
