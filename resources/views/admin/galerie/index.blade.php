@extends('admin.layouts.admin')
@section('title', 'Galerie')
@section('breadcrumb', 'Galerie')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Galerie photos</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $photos->total() }} photo(s) au total</p>
    </div>
    <a href="{{ route('admin.galerie.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Ajouter des photos
    </a>
</div>

@if($photos->isEmpty())
<div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
    <div class="text-5xl mb-4">🎨</div>
    <h3 class="font-bold text-gray-700 mb-2">Aucune photo pour le moment</h3>
    <p class="text-gray-400 text-sm mb-6">Ajoutez vos premières photos.</p>
    <a href="{{ route('admin.galerie.create') }}" class="btn-primary">Ajouter des photos</a>
</div>
@else

{{-- Grille de photos --}}
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
    @foreach($photos as $photo)
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden group">

        {{-- Image --}}
        <div class="relative overflow-hidden h-44">
            <img src="{{ Storage::url($photo->image) }}"
                 alt="{{ $photo->legende ?? 'Photo' }}"
                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">

            {{-- Badge homepage --}}
            @if($photo->homepage)
            <div class="absolute top-2 left-2">
                <span class="badge badge-green text-xs">🏠 Home</span>
            </div>
            @endif
        </div>

        {{-- Infos --}}
        <div class="p-3">
            @if($photo->legende)
            <p class="text-xs text-gray-600 font-medium truncate mb-1">{{ $photo->legende }}</p>
            @endif
            @if($photo->categorie)
            <span class="badge badge-blue text-xs">{{ $photo->categorie }}</span>
            @endif

            {{-- Actions --}}
            <div class="flex items-center gap-2 mt-3">
                <a href="{{ route('admin.galerie.edit', $photo->id) }}"
                   class="btn-edit text-xs flex-1 justify-center">
                    ✏️ Modifier
                </a>
                <form method="POST" action="{{ route('admin.galerie.destroy', $photo->id) }}"
                      onsubmit="return confirm('Supprimer cette photo ?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">🗑️</button>
                </form>
            </div>

            {{-- Toggle homepage --}}
            <form method="POST" action="{{ route('admin.galerie.toggle', $photo->id) }}" class="mt-2">
                @csrf
                <button type="submit"
                        class="w-full text-xs py-1.5 rounded-lg font-medium transition-colors
                               {{ $photo->homepage
                                   ? 'bg-green-50 text-green-600 hover:bg-green-100'
                                   : 'bg-gray-50 text-gray-500 hover:bg-gray-100' }}">
                    {{ $photo->homepage ? '✅ Sur la home' : '➕ Mettre sur la home' }}
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

<div class="mt-6">
    {{ $photos->links() }}
</div>
@endif

@endsection