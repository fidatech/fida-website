<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'project_type',
        'budget',
        'message',
        'locale',
        'source_url',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'status',
    ];
}
