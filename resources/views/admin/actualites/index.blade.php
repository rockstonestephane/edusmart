@extends('admin.layouts.admin')
@section('title', 'Actualités')
@section('breadcrumb', 'Actualités')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Actualités</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $actualites->total() }} actualité(s) au total</p>
    </div>
    <a href="{{ route('admin.actualites.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nouvelle actualité
    </a>
</div>

@if($actualites->isEmpty())
<div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
    <div class="text-5xl mb-4">📰</div>
    <h3 class="font-bold text-gray-700 mb-2">Aucune actualité pour le moment</h3>
    <p class="text-gray-400 text-sm mb-6">Créez votre première actualité.</p>
    <a href="{{ route('admin.actualites.create') }}" class="btn-primary">Créer une actualité</a>
</div>
@else
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Titre</th>
                <th>Catégorie</th>
                <th>Date</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($actualites as $actu)
            <tr>
                <td>
                    <img src="{{ Storage::url($actu->image) }}"
                         class="w-16 h-10 object-cover rounded-lg">
                </td>
                <td>
                    <div class="font-semibold text-gray-800 text-sm max-w-xs truncate">
                        {{ $actu->titre }}
                    </div>
                    <div class="text-xs text-gray-400 mt-0.5 max-w-xs truncate">
                        {{ $actu->extrait }}
                    </div>
                </td>
                <td>
                    <span class="badge badge-blue">{{ $actu->categorie }}</span>
                </td>
                <td class="text-xs text-gray-500">
                    {{ $actu->published_at?->format('d/m/Y') }}
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.actualites.toggle', $actu->id) }}">
                        @csrf
                        <button type="submit"
                                class="badge {{ $actu->publiee ? 'badge-green' : 'badge-red' }} cursor-pointer border-0 bg-transparent">
                            {{ $actu->publiee ? '✅ Publiée' : '❌ Masquée' }}
                        </button>
                    </form>
                </td>
                <td>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.actualites.edit', $actu->id) }}" class="btn-edit">
                            ✏️ Modifier
                        </a>
                        <form method="POST" action="{{ route('admin.actualites.destroy', $actu->id) }}"
                              onsubmit="return confirm('Supprimer cette actualité ?')">
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
        {{ $actualites->links() }}
    </div>
</div>
@endif

@endsection