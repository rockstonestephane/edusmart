@extends('admin.layouts.admin')
@section('title', 'Rentrée Scolaire')
@section('breadcrumb', 'Rentrée Scolaire')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Rentrée Scolaire</h1>
        <p class="text-sm text-gray-500 mt-1">Gérez la section rentrée scolaire de la page d'accueil</p>
    </div>
    <a href="{{ route('admin.rentree-scolaire.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nouvelle rentrée
    </a>
</div>

<div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6 text-sm text-blue-700">
    💡 <strong>Une seule rentrée active à la fois.</strong> Activer une rentrée désactive automatiquement les autres.
</div>

@if($rentrees->isEmpty())
<div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
    <div class="text-5xl mb-4">📅</div>
    <h3 class="font-bold text-gray-700 mb-2">Aucune rentrée scolaire configurée</h3>
    <p class="text-gray-400 text-sm mb-6">Créez la rentrée scolaire à afficher sur la page d'accueil.</p>
    <a href="{{ route('admin.rentree-scolaire.create') }}" class="btn-primary">
        Créer la rentrée scolaire
    </a>
</div>
@else
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Année</th>
                <th>Titre</th>
                <th>Boutons</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rentrees as $rentree)
            <tr>
                <td>
                    <div class="font-bold text-blue-700 text-lg">{{ $rentree->annee }}</div>
                    @if($rentree->badge_label)
                        <span class="badge badge-blue text-xs">{{ $rentree->badge_label }}</span>
                    @endif
                </td>
                <td>
                    <div class="font-semibold text-gray-800 text-sm">{{ $rentree->titre }}</div>
                    @if($rentree->description)
                        <div class="text-xs text-gray-400 mt-0.5 truncate max-w-xs">{{ $rentree->description }}</div>
                    @endif
                </td>
                <td>
                    <div class="text-xs text-gray-500">
                        @if($rentree->btn1_label)
                            <span class="badge badge-blue mb-1">{{ $rentree->btn1_label }}</span>
                        @endif
                        @if($rentree->btn2_label)
                            <span class="badge badge-gray">{{ $rentree->btn2_label }}</span>
                        @endif
                        @if(!$rentree->btn1_label && !$rentree->btn2_label)
                            <span class="text-gray-300">—</span>
                        @endif
                    </div>
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.rentree-scolaire.toggle', $rentree->id) }}">
                        @csrf
                        <button type="submit"
                                class="badge {{ $rentree->actif ? 'badge-green' : 'badge-red' }} cursor-pointer border-0 bg-transparent">
                            {{ $rentree->actif ? '✅ Active' : '❌ Inactive' }}
                        </button>
                    </form>
                </td>
                <td>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.rentree-scolaire.edit', $rentree->id) }}" class="btn-edit">
                            ✏️ Modifier
                        </a>
                        <form method="POST"
                              action="{{ route('admin.rentree-scolaire.destroy', $rentree->id) }}"
                              onsubmit="return confirm('Supprimer cette rentrée scolaire ?')">
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
</div>
@endif

@endsection