<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactAdminController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->paginate(20);
        $nonLus   = Contact::nonLus()->count();

        return view('admin.contacts.index', compact('contacts', 'nonLus'));
    }

    public function show(Contact $contact)
    {
        // Marquer comme lu automatiquement
        if (!$contact->lu) {
            $contact->marquerLu();
        }

        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message supprimé.');
    }

    public function toggleLu(Contact $contact)
    {
        $contact->update([
            'lu'    => !$contact->lu,
            'lu_at' => !$contact->lu ? now() : null,
        ]);

        return back()->with('success', 'Statut mis à jour.');
    }
}