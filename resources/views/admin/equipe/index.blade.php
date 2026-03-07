@extends('admin.layouts.admin')
@section('title', 'Équipe de direction')
@section('breadcrumb', 'Équipe de direction')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Équipe de direction</h1>
        <p class="text-sm text-gray-500 mt-1">Gérez les membres affichés sur la page À propos</p>
    </div>
    <a href="{{ route('admin.equipe.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nouveau membre
    </a>
</div>

@if($membres->isEmpty())
<div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
    <div class="text-5xl mb-4">👥</div>
    <h3 class="font-bold text-gray-700 mb-2">Aucun membre pour le moment</h3>
    <p class="text-gray-400 text-sm mb-6">Ajoutez les membres de l'équipe de direction.</p>
    <a href="{{ route('admin.equipe.create') }}" class="btn-primary">
        Ajouter le premier membre
    </a>
</div>
@else
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Ordre</th>
                <th>Photo</th>
                <th>Nom</th>
                <th>Poste</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($membres as $membre)
            <tr>
                <td>
                    <span class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center
                                 text-sm font-bold text-gray-600">
                        {{ $membre->ordre }}
                    </span>
                </td>
                <td>
                    @if($membre->photo)
                        <img src="{{ Storage::url($membre->photo) }}"
                             alt="{{ $membre->nom }}"
                             class="w-12 h-12 object-cover rounded-full border border-gray-200">
                    @else
                        <div class="w-12 h-12 rounded-full flex items-center justify-center text-lg
                                    font-bold text-white"
                             style="background:linear-gradient(135deg,#2952f5,#152dd4)">
                            {{ mb_substr($membre->nom, 0, 1) }}
                        </div>
                    @endif
                </td>
                <td>
                    <div class="font-semibold text-gray-800 text-sm">{{ $membre->nom }}</div>
                </td>
                <td>
                    <div class="text-sm text-blue-600 font-medium">{{ $membre->poste }}</div>
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.equipe.toggle', $membre->id) }}">
                        @csrf
                        <button type="submit"
                                class="badge {{ $membre->actif ? 'badge-green' : 'badge-red' }} cursor-pointer border-0 bg-transparent">
                            {{ $membre->actif ? '✅ Actif' : '❌ Inactif' }}
                        </button>
                    </form>
                </td>
                <td>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.equipe.edit', $membre->id) }}" class="btn-edit">
                            ✏️ Modifier
                        </a>
                        <form method="POST"
                              action="{{ route('admin.equipe.destroy', $membre->id) }}"
                              onsubmit="return confirm('Supprimer ce membre ?')">
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