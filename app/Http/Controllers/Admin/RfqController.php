<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateRfqRequest;
use App\Models\Rfq;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RfqController extends Controller
{
    public function index(Request $request): View
    {
        $rfqs = Rfq::query()
            ->with('assignee')
            ->when($request->filled('status'), fn ($query) => $query->where('status', (string) $request->string('status')))
            ->when($request->filled('search'), fn ($query) => $query->where(function ($query) use ($request): void {
                $term = '%'.(string) $request->string('search')->trim().'%';
                $query->where('reference', 'like', $term)
                    ->orWhere('organization', 'like', $term)
                    ->orWhere('contact_name', 'like', $term)
                    ->orWhere('email', 'like', $term)
                    ->orWhere('project_title', 'like', $term);
            }))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        return view('admin.rfqs.index', compact('rfqs'));
    }

    public function show(Rfq $rfq): View
    {
        $rfq->load('assignee');

        $assignees = User::query()
            ->where('active', true)
            ->whereIn('role', ['super_admin', 'sales'])
            ->orderBy('name')
            ->get(['id', 'name', 'role']);

        return view('admin.rfqs.show', compact('rfq', 'assignees'));
    }

    public function update(UpdateRfqRequest $request, Rfq $rfq): RedirectResponse
    {
        $data = $request->validated();

        if ($data['status'] !== 'new' && ! $rfq->reviewed_at) {
            $data['reviewed_at'] = now();
        }

        $rfq->update($data);

        return back()->with('success', 'RFQ updated.');
    }

    public function attachment(Rfq $rfq, int $attachment): StreamedResponse
    {
        $files = $rfq->attachments ?? [];
        abort_unless(isset($files[$attachment]), 404);

        $file = $files[$attachment];
        abort_unless(Storage::disk('local')->exists($file['path']), 404);

        return Storage::disk('local')->download($file['path'], $file['name']);
    }
}
