<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Contact;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ContactResource;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;

class ContactsController extends Controller
{
    public function index()
    {
        // dd(Request::all());
        // $a = Auth::user()->account->contacts()
        //     ->with('organization', function ($q) {
        //         return $q->select(['id', 'name']);
        //     })
        //     ->orderByName()
        //     ->filter(Request::only('search', 'trashed'))
        //     ->paginate()
        //     ->withQueryString()->through(function ($contact) {
        //         $contact->name = $contact->name;
        //         return $contact;
        //     });

        // dd($a);

        return Inertia::render('Admin/Contacts/Index', [
            'filters' => Request::all('search', 'trashed'),
            'contacts' => Auth::user()->account->contacts()
                ->with('organization', function ($q) {
                    return $q->select(['id', 'name']);
                })
                //->orderByName()
                ->filter(Request::only('search', 'trashed'))
                ->orderBy('id', 'desc')
                ->paginate()
                ->withQueryString()
                ->through(function ($contact) {
                    $contact->name = $contact->name;
                    return $contact;
                    // return [
                    //     'id' => $contact->id,
                    //     'name' => $contact->name,
                    //     'phone' => $contact->phone,
                    //     'city' => $contact->city,
                    //     'deleted_at' => $contact->deleted_at,
                    //     'organization' => $contact->organization ? $contact->organization->only('name') : null,
                    // ];
                }),
        ]);
    }

    public function create()
    {
        // $o = Auth::user()->account
        //     ->organizations()
        //     ->orderBy('name')
        //     ->select(['id', 'name'])
        //     ->get();
        // // ->map
        // // ->only('id', 'name');
        // // ->map(function ($e) {
        // //     return [
        // //         'id' => $e->id,
        // //         'name' => $e->name,
        // //     ];
        // // });

        //dd($o);
        return Inertia::render('Admin/Contacts/Create', [
            'organizations' => Auth::user()->account
                ->organizations()
                ->orderBy('name')
                ->select(['id', 'name'])
                ->get()
            // ->map
            // ->only('id', 'name')
        ]);
    }

    public function store()
    {
        Auth::user()->account->contacts()->create(
            Request::validate([
                'first_name' => ['required', 'max:50'],
                'last_name' => ['required', 'max:50'],
                'organization_id' => ['nullable', Rule::exists('organizations', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );

        //return Redirect::route('contacts')->with('success', 'Contact created.');
        return back()->with('success', 'Contact created.');
    }

    public function edit(Contact $contact)
    {
        return Inertia::render('Admin/Contacts/Edit', [
            'contact' =>  new ContactResource($contact),
            'organizations' => Auth::user()->account->organizations()
                ->orderBy('name')
                ->select(['id', 'name'])
                ->get()
            // ->map
            // ->only('id', 'name'),
        ]);
    }

    public function update(Contact $contact)
    {
        $contact->update(
            Request::validate([
                'first_name' => ['required', 'max:50'],
                'last_name' => ['required', 'max:50'],
                'organization_id' => ['nullable', Rule::exists('organizations', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
            ])
        );

        return back()->with('success', 'Contact updated.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return Redirect::back()->with('success', 'Contact deleted.');
    }

    public function restore(Contact $contact)
    {
        $contact->restore();

        return Redirect::back()->with('success', 'Contact restored.');
    }
}
