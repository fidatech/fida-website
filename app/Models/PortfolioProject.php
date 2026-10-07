<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PortfolioProject extends Model
{
    protected $fillable = ['client_id','name','slug','project_type','status','started_at','completed_at','technologies','summary','description','live_url','repository_url','public','content_page_id'];

    protected function casts(): array
    {
        return ['started_at'=>'date','completed_at'=>'date','technologies'=>'array','public'=>'boolean'];
    }

    public function client(): BelongsTo { return $this->belongsTo(Client::class); }
    public function contentPage(): BelongsTo { return $this->belongsTo(ContentPage::class); }
    public function screenshots(): HasMany { return $this->hasMany(ProjectScreenshot::class)->orderBy('sort_order')->orderBy('id'); }
    public function contracts(): HasMany { return $this->hasMany(Contract::class); }
}
