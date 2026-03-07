@extends('admin.layouts.admin')
@section('title', 'Statistiques')
@section('breadcrumb', 'Statistiques')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Statistiques</h1>
        <p class="text-sm text-gray-500 mt-1">Gérez les chiffres clés affichés sur le site</p>
    </div>
    <a href="{{ route('admin.statistiques.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nouvelle statistique
    </a>
</div>

@if($statistiques->isEmpty())
<div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
    <div class="text-5xl mb-4">📊</div>
    <h3 class="font-bold text-gray-700 mb-2">Aucune statistique pour le moment</h3>
    <p class="text-gray-400 text-sm mb-6">Créez vos premières statistiques (ex: élèves inscrits, taux de réussite...).</p>
    <a href="{{ route('admin.statistiques.create') }}" class="btn-primary">
        Créer la première statistique
    </a>
</div>
@else
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Ordre</th>
                <th>Icône</th>
                <th>Valeur</th>
                <th>Label</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statistiques as $stat)
            <tr>
                <td>
                    <span class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center
                                 text-sm font-bold text-gray-600">
                        {{ $stat->ordre }}
                    </span>
                </td>
                <td>
                    <span class="text-2xl">{{ $stat->icone ?? '—' }}</span>
                </td>
                <td>
                    <div class="font-bold text-blue-700 text-lg">
                        {{ $stat->valeur }}{{ $stat->suffixe }}
                    </div>
                </td>
                <td>
                    <div class="text-sm text-gray-700">{{ $stat->label }}</div>
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.statistiques.toggle', $stat->id) }}">
                        @csrf
                        <button type="submit"
                                class="badge {{ $stat->actif ? 'badge-green' : 'badge-red' }} cursor-pointer border-0 bg-transparent">
                            {{ $stat->actif ? '✅ Actif' : '❌ Inactif' }}
                        </button>
                    </form>
                </td>
                <td>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.statistiques.edit', $stat->id) }}" class="btn-edit">
                            ✏️ Modifier
                        </a>
                        <form method="POST"
                              action="{{ route('admin.statistiques.destroy', $stat->id) }}"
                              onsubmit="return confirm('Supprimer cette statistique ?')">
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