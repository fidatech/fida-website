<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request): View
    {
        $clients = Client::query()
            ->withCount(['contracts','projects'])
            ->when($request->filled('search'), function ($query) use ($request): void {
                $term = '%'.trim((string) $request->string('search')).'%';
                $query->where(fn ($q) => $q->where('name','like',$term)->orWhere('company_name','like',$term)->orWhere('sector','like',$term));
            })
            ->latest('updated_at')->paginate(25)->withQueryString();

        return view('admin.clients.index', compact('clients'));
    }

    public function create(): View
    {
        return view('admin.clients.form', ['client' => new Client()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $client = Client::query()->create($this->validated($request));

        return redirect()->route('admin.clients.edit', $client)->with('success', 'Client added.');
    }

    public function edit(Client $client): View
    {
        $client->load(['contracts.project','projects']);

        return view('admin.clients.form', compact('client'));
    }

    public function update(Request $request, Client $client): RedirectResponse
    {
        $client->update($this->validated($request));

        return back()->with('success', 'Client updated.');
    }

    public function destroy(Client $client): RedirectResponse
    {
        abort_if($client->contracts()->exists() || $client->projects()->exists(), 422, 'Clients with projects or contracts cannot be deleted.');
        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Client deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'=>['required','string','max:190'],
            'company_name'=>['nullable','string','max:190'],
            'sector'=>['nullable','string','max:120'],
            'contact_person'=>['nullable','string','max:190'],
            'email'=>['nullable','email','max:190'],
            'phone'=>['nullable','string','max:60'],
            'whatsapp'=>['nullable','string','max:60'],
            'address'=>['nullable','string','max:3000'],
            'website'=>['nullable','url:http,https','max:512'],
            'status'=>['required','in:lead,active,inactive,completed'],
            'notes'=>['nullable','string','max:5000'],
        ]);
    }
}
