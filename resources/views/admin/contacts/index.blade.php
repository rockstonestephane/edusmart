@extends('admin.layouts.admin')
@section('title', 'Messages de contact')
@section('breadcrumb', 'Contacts')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Messages de contact</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $contacts->total() }} message(s) au total</p>
    </div>
</div>

{{-- Stats rapides --}}
<div class="grid grid-cols-2 md:grid-cols-2 gap-4 mb-6">
    <div class="stat-card text-center">
        <div class="text-2xl font-bold text-gray-800 mb-1">{{ $contacts->total() }}</div>
        <span class="badge badge-blue">Total</span>
    </div>
    <div class="stat-card text-center">
        <div class="text-2xl font-bold text-gray-800 mb-1">{{ $nonLus }}</div>
        <span class="badge badge-yellow">Non lus</span>
    </div>
</div>

@if($contacts->isEmpty())
<div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
    <div class="text-5xl mb-4">✉️</div>
    <h3 class="font-bold text-gray-700 mb-2">Aucun message reçu</h3>
    <p class="text-gray-400 text-sm">Les messages envoyés depuis le formulaire de contact apparaîtront ici.</p>
</div>
@else
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Expéditeur</th>
                <th>Sujet</th>
                <th>Message</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
            <tr class="{{ !$contact->lu ? 'bg-blue-50/40' : '' }}">
                <td class="text-xs text-gray-400">
                    {{ $contact->created_at->format('d/m/Y') }}<br>
                    <span class="text-gray-300">{{ $contact->created_at->format('H:i') }}</span>
                </td>
                <td>
                    <div class="font-semibold text-gray-800 text-sm">{{ $contact->nom }}</div>
                    <div class="text-xs text-gray-400">{{ $contact->email }}</div>
                </td>
                <td>
                    <span class="text-sm text-gray-700">{{ $contact->sujet }}</span>
                </td>
                <td>
                    <span class="text-sm text-gray-500">
                        {{ Str::limit($contact->message, 60) }}
                    </span>
                </td>
                <td>
                    @if($contact->lu)
                        <span class="badge badge-green">✅ Lu</span>
                    @else
                        <span class="badge badge-yellow">🔵 Non lu</span>
                    @endif
                </td>
                <td>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.contacts.show', $contact->id) }}"
                           class="btn-edit">👁️ Voir</a>

                        <form method="POST"
                              action="{{ route('admin.contacts.toggle-lu', $contact->id) }}">
                            @csrf
                            <button type="submit" class="btn-outline text-xs"
                                    title="{{ $contact->lu ? 'Marquer non lu' : 'Marquer lu' }}">
                                {{ $contact->lu ? '📭' : '📬' }}
                            </button>
                        </form>

                        <form method="POST"
                              action="{{ route('admin.contacts.destroy', $contact->id) }}"
                              onsubmit="return confirm('Supprimer ce message ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger">🗑️</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $contacts->links() }}
    </div>
</div>
@endif

@endsection