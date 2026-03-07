@extends('admin.layouts.admin')
@section('title', 'Nos Valeurs')
@section('breadcrumb', 'Nos Valeurs')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Nos Valeurs</h1>
        <p class="text-sm text-gray-500 mt-1">Gérez les valeurs affichées sur la page À propos</p>
    </div>
    <a href="{{ route('admin.valeurs.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nouvelle valeur
    </a>
</div>

@if($valeurs->isEmpty())
<div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
    <div class="text-5xl mb-4">💎</div>
    <h3 class="font-bold text-gray-700 mb-2">Aucune valeur pour le moment</h3>
    <p class="text-gray-400 text-sm mb-6">Créez vos premières valeurs (ex: Excellence, Bienveillance...).</p>
    <a href="{{ route('admin.valeurs.create') }}" class="btn-primary">
        Créer la première valeur
    </a>
</div>
@else
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Ordre</th>
                <th>Icône</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Couleur</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($valeurs as $valeur)
            <tr>
                <td>
                    <span class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center
                                 text-sm font-bold text-gray-600">
                        {{ $valeur->ordre }}
                    </span>
                </td>
                <td>
                    <span class="text-2xl">{{ $valeur->icone ?? '—' }}</span>
                </td>
                <td>
                    <div class="font-semibold text-gray-800 text-sm">{{ $valeur->titre }}</div>
                </td>
                <td>
                    <div class="text-xs text-gray-500 max-w-xs truncate">{{ $valeur->description }}</div>
                </td>
                <td>
                    <span class="inline-block w-6 h-6 rounded-lg bg-gradient-to-br {{ $valeur->couleur }}"></span>
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.valeurs.toggle', $valeur->id) }}">
                        @csrf
                        <button type="submit"
                                class="badge {{ $valeur->actif ? 'badge-green' : 'badge-red' }} cursor-pointer border-0 bg-transparent">
                            {{ $valeur->actif ? '✅ Actif' : '❌ Inactif' }}
                        </button>
                    </form>
                </td>
                <td>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.valeurs.edit', $valeur->id) }}" class="btn-edit">
                            ✏️ Modifier
                        </a>
                        <form method="POST"
                              action="{{ route('admin.valeurs.destroy', $valeur->id) }}"
                              onsubmit="return confirm('Supprimer cette valeur ?')">
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