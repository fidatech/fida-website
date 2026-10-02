<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SearchConsoleMetric extends Model
{
    protected $fillable = ['metric_type','dimension','clicks','impressions','ctr','position','period_start','period_end','imported_at'];

    protected function casts(): array
    {
        return ['ctr'=>'decimal:6','position'=>'decimal:2','period_start'=>'date','period_end'=>'date','imported_at'=>'datetime'];
    }
}
