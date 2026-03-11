@extends('admin.layouts.admin')
@section('title', 'Hero Slides')
@section('breadcrumb', 'Hero Slides')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Hero Slides</h1>
        <p class="text-sm text-gray-500 mt-1">Gérez les slides du diaporama principal</p>
    </div>
    <a href="{{ route('admin.hero-slides.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Nouveau slide
    </a>
</div>

@if($slides->isEmpty())
<div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
    <div class="text-5xl mb-4">🖼️</div>
    <h3 class="font-bold text-gray-700 mb-2">Aucun slide pour le moment</h3>
    <p class="text-gray-400 text-sm mb-6">Créez votre premier slide pour le diaporama de la page d'accueil.</p>
    <a href="{{ route('admin.hero-slides.create') }}" class="btn-primary">
        Créer le premier slide
    </a>
</div>
@else
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Ordre</th>
                <th>Aperçu</th>
                <th>Titre</th>
                <th>Boutons</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($slides as $slide)
            <tr>
                <td>
                    <span class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center
                                 text-sm font-bold text-gray-600">
                        {{ $slide->ordre }}
                    </span>
                </td>
                <td>
                    <img src="{{ $slide->image  }}"
                         alt="{{ $slide->titre }}"
                         class="w-20 h-12 object-cover rounded-lg">
                </td>
                <td>
                    <div class="font-semibold text-gray-800 text-sm">{{ $slide->titre }}</div>
                    @if($slide->surtitre)
                    <div class="text-xs text-gray-400 mt-0.5">{{ $slide->surtitre }}</div>
                    @endif
                </td>
                <td>
                    <div class="text-xs text-gray-500">
                        @if($slide->btn1_label)
                            <span class="badge badge-blue mb-1">{{ $slide->btn1_label }}</span>
                        @endif
                        @if($slide->btn2_label)
                            <span class="badge badge-gray">{{ $slide->btn2_label }}</span>
                        @endif
                        @if(!$slide->btn1_label && !$slide->btn2_label)
                            <span class="text-gray-300">—</span>
                        @endif
                    </div>
                </td>
                <td>
                    <form method="POST"
                          action="{{ route('admin.hero-slides.toggle', $slide->id) }}">
                        @csrf
                        <button type="submit"
                                class="badge {{ $slide->actif ? 'badge-green' : 'badge-red' }} cursor-pointer border-0 bg-transparent">
                            {{ $slide->actif ? '✅ Actif' : '❌ Inactif' }}
                        </button>
                    </form>
                </td>
                <td>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.hero-slides.edit', $slide->id) }}"
                           class="btn-edit">
                            ✏️ Modifier
                        </a>
                        <form method="POST"
                              action="{{ route('admin.hero-slides.destroy', $slide->id) }}"
                              onsubmit="return confirm('Supprimer ce slide ?')">
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