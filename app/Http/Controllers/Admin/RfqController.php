<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rfq;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RfqController extends Controller
{
    public function index(): View
    {
        return view('admin.rfqs.index', [
            'rfqs' => Rfq::query()->latest()->paginate(30),
        ]);
    }

    public function show(Rfq $rfq): View
    {
        if ($rfq->status === 'new') {
            $rfq->forceFill(['reviewed_at' => now()])->save();
        }

        return view('admin.rfqs.show', compact('rfq'));
    }

    public function update(Request $request, Rfq $rfq): RedirectResponse
    {
        $data = $request->validate(['status' => ['required','in:new,reviewing,qualified,quoted,closed']]);
        $rfq->update($data);

        return back()->with('success', 'RFQ status updated.');
    }

    public function download(Rfq $rfq): StreamedResponse
    {
        abort_unless($rfq->attachment_path && Storage::disk('local')->exists($rfq->attachment_path), 404);

        return Storage::disk('local')->download($rfq->attachment_path, $rfq->attachment_name ?: basename($rfq->attachment_path));
    }
}
