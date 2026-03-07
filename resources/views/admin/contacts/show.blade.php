@extends('admin.layouts.admin')
@section('title', 'Message de ' . $contact->nom)
@section('breadcrumb', 'Contacts')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Message de {{ $contact->nom }}</h1>
        <p class="text-sm text-gray-500 mt-1">
            Reçu le {{ $contact->created_at->format('d/m/Y à H:i') }}
        </p>
    </div>
    <a href="{{ route('admin.contacts.index') }}" class="btn-outline">
        ← Retour
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Infos expéditeur --}}
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="font-bold text-gray-700 mb-4 text-sm uppercase tracking-wide">
            👤 Expéditeur
        </h2>
        <div class="space-y-3">
            <div>
                <p class="text-xs text-gray-400 mb-1">Nom</p>
                <p class="font-semibold text-gray-800">{{ $contact->nom }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">Email</p>
                <a href="mailto:{{ $contact->email }}"
                   class="text-blue-600 hover:underline text-sm">
                    {{ $contact->email }}
                </a>
            </div>
            <div>
                <p class="text-xs text-gray-400 mb-1">Statut</p>
                @if($contact->lu)
                    <span class="badge badge-green">✅ Lu</span>
                    @if($contact->lu_at)
                    <p class="text-xs text-gray-400 mt-1">
                        le {{ $contact->lu_at->format('d/m/Y à H:i') }}
                    </p>
                    @endif
                @else
                    <span class="badge badge-yellow">🔵 Non lu</span>
                @endif
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-6 space-y-2">
            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->sujet }}"
               class="btn-primary w-full text-center block">
                ✉️ Répondre par email
            </a>

            <form method="POST"
                  action="{{ route('admin.contacts.toggle-lu', $contact->id) }}">
                @csrf
                <button type="submit" class="btn-outline w-full">
                    {{ $contact->lu ? '📭 Marquer non lu' : '📬 Marquer lu' }}
                </button>
            </form>

            <form method="POST"
                  action="{{ route('admin.contacts.destroy', $contact->id) }}"
                  onsubmit="return confirm('Supprimer ce message ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger w-full">
                    🗑️ Supprimer
                </button>
            </form>
        </div>
    </div>

    {{-- Contenu du message --}}
    <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="font-bold text-gray-700 mb-1 text-sm uppercase tracking-wide">
            💬 Message
        </h2>
        <p class="text-xs text-gray-400 mb-4">Sujet : <span class="font-medium text-gray-600">{{ $contact->sujet }}</span></p>

        <div class="bg-gray-50 rounded-xl p-5 text-sm text-gray-700 leading-relaxed whitespace-pre-wrap border border-gray-100">
            {{ $contact->message }}
        </div>
    </div>

</div>

@endsection