<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsitePageView extends Model
{
    protected $fillable = [
        'occurred_at','day','visitor_key','session_key','path','route_name','page_slug','locale',
        'referrer_url','referrer_host','source','medium','campaign','search_engine','search_query',
        'country_code','device_type','browser','platform','is_bot','bot_name','user_agent','ip_hash','status_code',
    ];

    protected function casts(): array
    {
        return ['occurred_at' => 'datetime', 'day' => 'date', 'is_bot' => 'boolean'];
    }
}
