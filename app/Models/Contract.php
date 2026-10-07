<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    protected $fillable = ['client_id','portfolio_project_id','contract_number','title','signed_at','starts_at','ends_at','amount','currency','status','payment_terms','scope_summary','notes','attachment_disk','attachment_path'];

    protected function casts(): array
    {
        return ['signed_at'=>'date','starts_at'=>'date','ends_at'=>'date','amount'=>'decimal:2'];
    }

    public function client(): BelongsTo { return $this->belongsTo(Client::class); }
    public function project(): BelongsTo { return $this->belongsTo(PortfolioProject::class, 'portfolio_project_id'); }
}
