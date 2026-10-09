<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rfq extends Model
{
    protected $fillable = [
        'reference', 'organization', 'organization_type', 'contact_name', 'job_title',
        'email', 'phone', 'procurement_type', 'project_title', 'submission_deadline',
        'location', 'budget', 'requirements', 'attachments', 'locale', 'source_url',
        'status', 'internal_notes', 'assigned_to', 'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'attachments' => 'array',
            'submission_deadline' => 'date',
            'reviewed_at' => 'datetime',
        ];
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
