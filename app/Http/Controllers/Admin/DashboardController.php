<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentPage;
use App\Models\Lead;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $canSeeLeads = $request->user()->allows('leads.manage');

        return view('admin.dashboard', [
            'pageCount' => ContentPage::query()->count(),
            'publishedCount' => ContentPage::published()->count(),
            'leadCount' => $canSeeLeads ? Lead::query()->count() : null,
            'newLeadCount' => $canSeeLeads ? Lead::query()->where('status', 'new')->count() : null,
            'latestLeads' => $canSeeLeads
                ? Lead::query()->latest()->limit(6)->get()
                : collect(),
        ]);
    }
}
