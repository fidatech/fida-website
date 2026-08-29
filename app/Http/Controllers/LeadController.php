<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;

class LeadController extends Controller
{
    public function __invoke(StoreLeadRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('website');
        $data['locale'] = $data['locale'] ?? app()->getLocale();
        $data['status'] = 'new';

        app()->setLocale($data['locale']);

        Lead::create($data);

        return back()->with('lead_success', __('website.contact.success'));
    }
}
