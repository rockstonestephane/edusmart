<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterAdminController extends Controller
{
    public function index()
    {
        $subscribers = NewsletterSubscriber::latest()->paginate(20);
        return view('admin.newsletter.index', compact('subscribers'));
    }

    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();
        return back()->with('success', 'Abonné supprimé avec succès.');
    }

    public function toggleActif(NewsletterSubscriber $subscriber)
    {
        $subscriber->update(['actif' => !$subscriber->actif]);
        return back()->with('success', 'Statut mis à jour.');
    }
}