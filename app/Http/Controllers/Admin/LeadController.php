<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateLeadRequest;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $leads = Lead::query()
            ->with('assignee')
            ->when($request->filled('status'), fn ($query) => $query->where('status', (string) $request->string('status')))
            ->when($request->filled('search'), fn ($query) => $query->where(function ($query) use ($request): void {
                $term = '%'.(string) $request->string('search')->trim().'%';
                $query->where('name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('phone', 'like', $term)
                    ->orWhere('company', 'like', $term);
            }))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('admin.leads.index', compact('leads'));
    }

    public function show(Lead $lead): View
    {
        $lead->load('assignee');

        $assignees = User::query()
            ->where('active', true)
            ->whereIn('role', ['super_admin', 'sales'])
            ->orderBy('name')
            ->get(['id', 'name', 'role']);

        return view('admin.leads.show', compact('lead', 'assignees'));
    }

    public function update(UpdateLeadRequest $request, Lead $lead): RedirectResponse
    {
        $data = $request->validated();

        if ($data['status'] !== 'new' && ! $lead->contacted_at) {
            $data['contacted_at'] = now();
        }

        $lead->update($data);

        return back()->with('success', 'Lead updated.');
    }
}
