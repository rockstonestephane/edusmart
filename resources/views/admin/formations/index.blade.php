@extends('admin.layouts.admin')
@section('title', 'Formations')
@section('breadcrumb', 'Formations')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Formations</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $formations->total() }} formation(s) au total</p>
    </div>
    <a href="{{ route('admin.formations.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nouvelle formation
    </a>
</div>

@if($formations->isEmpty())
<div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
    <div class="text-5xl mb-4">📚</div>
    <h3 class="font-bold text-gray-700 mb-2">Aucune formation pour le moment</h3>
    <p class="text-gray-400 text-sm mb-6">Créez votre première formation.</p>
    <a href="{{ route('admin.formations.create') }}" class="btn-primary">Créer une formation</a>
</div>
@else
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Ordre</th>
                <th>Icône</th>
                <th>Titre</th>
                <th>Tags</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($formations as $formation)
            <tr>
                <td>
                    <span class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center
                                 text-sm font-bold text-gray-600">
                        {{ $formation->ordre }}
                    </span>
                </td>
                <td>
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl"
                         style="background:linear-gradient(135deg,{{ $formation->color ?? '#2952f5,#152dd4' }})">
                        {{ $formation->icon ?? '📚' }}
                    </div>
                </td>
                <td>
                    <div class="font-semibold text-gray-800 text-sm">{{ $formation->titre }}</div>
                    <div class="text-xs text-gray-400 mt-0.5 max-w-xs truncate">{{ $formation->extrait }}</div>
                </td>
                <td>
                    <div class="flex flex-wrap gap-1">
                        @foreach(($formation->tags ?? []) as $tag)
                        <span class="badge badge-gray text-xs">{{ $tag }}</span>
                        @endforeach
                    </div>
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.formations.toggle', $formation->id) }}">
                        @csrf
                        <button type="submit"
                                class="badge {{ $formation->active ? 'badge-green' : 'badge-red' }} cursor-pointer border-0 bg-transparent">
                            {{ $formation->active ? '✅ Active' : '❌ Inactive' }}
                        </button>
                    </form>
                </td>
                <td>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.formations.edit', $formation->id) }}" class="btn-edit">
                            ✏️ Modifier
                        </a>
                        <form method="POST" action="{{ route('admin.formations.destroy', $formation->id) }}"
                              onsubmit="return confirm('Supprimer cette formation ?')">
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
        {{ $formations->links() }}
    </div>
</div>
@endif

@endsection