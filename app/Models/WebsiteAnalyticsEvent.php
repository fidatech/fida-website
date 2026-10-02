<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteAnalyticsEvent extends Model
{
    protected $fillable = ['occurred_at','day','visitor_key','session_key','event_name','event_label','path','page_slug','locale','metadata'];

    protected function casts(): array
    {
        return ['occurred_at' => 'datetime', 'day' => 'date', 'metadata' => 'array'];
    }
}
