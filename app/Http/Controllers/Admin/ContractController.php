<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Contract;
use App\Models\PortfolioProject;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContractController extends Controller
{
    public function index(): View
    {
        return view('admin.contracts.index', [
            'contracts' => Contract::query()->with(['client','project'])->latest('signed_at')->latest()->paginate(30),
        ]);
    }

    public function create(Request $request): View
    {
        return $this->formView(new Contract(['client_id' => $request->integer('client_id') ?: null]));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('attachment')) {
            $data['attachment_disk'] = 'local';
            $data['attachment_path'] = $request->file('attachment')->store('contracts', 'local');
        }

        $contract = Contract::query()->create($data);

        return redirect()->route('admin.contracts.edit', $contract)->with('success', 'Contract recorded.');
    }

    public function edit(Contract $contract): View
    {
        return $this->formView($contract);
    }

    public function update(Request $request, Contract $contract): RedirectResponse
    {
        $data = $this->validated($request, $contract);

        if ($request->boolean('remove_attachment') && $contract->attachment_path) {
            Storage::disk($contract->attachment_disk ?: 'local')->delete($contract->attachment_path);
            $data['attachment_disk'] = null;
            $data['attachment_path'] = null;
        }

        if ($request->hasFile('attachment')) {
            if ($contract->attachment_path) {
                Storage::disk($contract->attachment_disk ?: 'local')->delete($contract->attachment_path);
            }
            $data['attachment_disk'] = 'local';
            $data['attachment_path'] = $request->file('attachment')->store('contracts', 'local');
        }

        $contract->update($data);

        return back()->with('success', 'Contract updated.');
    }

    public function download(Contract $contract)
    {
        abort_unless($contract->attachment_path, 404);

        return Storage::disk($contract->attachment_disk ?: 'local')->download(
            $contract->attachment_path,
            basename($contract->attachment_path),
        );
    }

    private function formView(Contract $contract): View
    {
        return view('admin.contracts.form', [
            'contract' => $contract,
            'clients' => Client::query()->orderBy('name')->get(),
            'projects' => PortfolioProject::query()->with('client')->orderBy('name')->get(),
        ]);
    }

    private function validated(Request $request, ?Contract $contract = null): array
    {
        return $request->validate([
            'client_id'=>['required','exists:clients,id'],
            'portfolio_project_id'=>['nullable','exists:portfolio_projects,id'],
            'contract_number'=>['nullable','string','max:120','unique:contracts,contract_number,'.($contract?->id ?? 'NULL')],
            'title'=>['required','string','max:190'],
            'signed_at'=>['nullable','date'],
            'starts_at'=>['nullable','date'],
            'ends_at'=>['nullable','date','after_or_equal:starts_at'],
            'amount'=>['nullable','numeric','min:0'],
            'currency'=>['required','string','max:12'],
            'status'=>['required','in:draft,active,completed,cancelled,expired'],
            'payment_terms'=>['nullable','string','max:5000'],
            'scope_summary'=>['nullable','string','max:7000'],
            'notes'=>['nullable','string','max:5000'],
            'attachment'=>['nullable','file','max:10240','mimes:pdf,doc,docx,jpg,jpeg,png'],
            'remove_attachment'=>['nullable','boolean'],
        ]);
    }
}
