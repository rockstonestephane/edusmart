@extends('admin.layouts.admin')
@section('title', 'Témoignages')
@section('breadcrumb', 'Témoignages')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Témoignages</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $temoignages->total() }} témoignage(s) au total</p>
    </div>
    <a href="{{ route('admin.temoignages.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nouveau témoignage
    </a>
</div>

@if($temoignages->isEmpty())
<div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
    <div class="text-5xl mb-4">💬</div>
    <h3 class="font-bold text-gray-700 mb-2">Aucun témoignage pour le moment</h3>
    <p class="text-gray-400 text-sm mb-6">Ajoutez votre premier témoignage.</p>
    <a href="{{ route('admin.temoignages.create') }}" class="btn-primary">Ajouter un témoignage</a>
</div>
@else
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Ordre</th>
                <th>Personne</th>
                <th>Témoignage</th>
                <th>Note</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($temoignages as $t)
            <tr>
                <td>
                    <span class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center
                                 text-sm font-bold text-gray-600">
                        {{ $t->ordre }}
                    </span>
                </td>
                <td>
                    <div class="flex items-center gap-3">
                        @if($t->photo)
                        <img src="{{ Storage::url($t->photo) }}"
                             class="w-10 h-10 rounded-full object-cover flex-shrink-0">
                        @else
                        <div class="w-10 h-10 rounded-full flex items-center justify-center
                                    text-white font-bold text-sm flex-shrink-0"
                             style="background:linear-gradient(135deg,#2952f5,#152dd4)">
                            {{ mb_strtoupper(mb_substr($t->nom, 0, 1)) }}
                        </div>
                        @endif
                        <div>
                            <div class="font-semibold text-gray-800 text-sm">{{ $t->nom }}</div>
                            <div class="text-xs text-gray-400">{{ $t->role }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    <p class="text-sm text-gray-600 max-w-xs truncate italic">
                        "{{ $t->texte }}"
                    </p>
                </td>
                <td>
                    <div class="flex gap-0.5">
                        @for($s = 1; $s <= 5; $s++)
                        <span class="{{ $s <= $t->note ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                        @endfor
                    </div>
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.temoignages.toggle', $t->id) }}">
                        @csrf
                        <button type="submit"
                                class="badge {{ $t->publie ? 'badge-green' : 'badge-red' }} cursor-pointer border-0 bg-transparent">
                            {{ $t->publie ? '✅ Publié' : '❌ Masqué' }}
                        </button>
                    </form>
                </td>
                <td>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.temoignages.edit', $t->id) }}" class="btn-edit">
                            ✏️ Modifier
                        </a>
                        <form method="POST" action="{{ route('admin.temoignages.destroy', $t->id) }}"
                              onsubmit="return confirm('Supprimer ce témoignage ?')">
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
        {{ $temoignages->links() }}
    </div>
</div>
@endif

@endsection