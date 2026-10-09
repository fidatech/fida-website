<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rfq extends Model
{
    protected $fillable = [
        'reference','organization_name','organization_type','contact_name','job_title','email','phone',
        'country','city','procurement_reference','procurement_method','submission_deadline','capabilities',
        'budget_currency','budget_min','budget_max','delivery_location','project_summary','scope_requirements',
        'compliance_requirements','timeline','attachment_path','attachment_name','attachment_mime',
        'attachment_size','locale','source_url','utm_source','utm_medium','utm_campaign','status','reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'capabilities' => 'array',
            'submission_deadline' => 'date',
            'reviewed_at' => 'datetime',
            'budget_min' => 'decimal:2',
            'budget_max' => 'decimal:2',
        ];
    }
}
