@extends('admin.layouts.admin')
@section('title', 'Page À propos')
@section('breadcrumb', 'Page À propos')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 p-8">
        <h1 class="text-xl font-bold text-gray-800 mb-2">Page À propos</h1>
        <p class="text-sm text-gray-500 mb-8">Gérez l'image hero et les textes de la section histoire</p>

        <form method="POST"
              action="{{ route('admin.about.update') }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- ── Image Hero ── --}}
            <div class="mb-8">
                <h2 class="text-base font-bold text-gray-700 mb-4 pb-2 border-b border-gray-100">
                    🖼️ Image Hero
                </h2>

                @if($about->hero_image)
                <div class="mb-4">
                    <p class="text-xs text-gray-400 mb-2">Image actuelle :</p>
                    <img src="{{ Storage::url($about->hero_image) }}"
                         alt="Hero About"
                         class="w-full h-48 object-cover rounded-xl border border-gray-200">
                </div>
                @endif

                <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ $about->hero_image ? 'Changer l\'image' : 'Ajouter une image' }}
                </label>
                <input type="file" name="hero_image" accept="image/*"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm
                              focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP — max 4Mo</p>
                @error('hero_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- ── Section Histoire ── --}}
            <div class="mb-8">
                <h2 class="text-base font-bold text-gray-700 mb-4 pb-2 border-b border-gray-100">
                    📖 Section Histoire
                </h2>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Paragraphe 1</label>
                    <textarea name="histoire_p1" rows="4" maxlength="1000"
                              placeholder="Fondé en ..., notre établissement..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm
                                     focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('histoire_p1', $about->histoire_p1) }}</textarea>
                    @error('histoire_p1') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Paragraphe 2</label>
                    <textarea name="histoire_p2" rows="4" maxlength="1000"
                              placeholder="Notre mission est d'offrir..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm
                                     focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('histoire_p2', $about->histoire_p2) }}</textarea>
                    @error('histoire_p2') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Paragraphe 3</label>
                    <textarea name="histoire_p3" rows="4" maxlength="1000"
                              placeholder="Accrédité par le MINESEC..."
                              class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm
                                     focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('histoire_p3', $about->histoire_p3) }}</textarea>
                    @error('histoire_p3') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="btn-primary">💾 Enregistrer</button>
            </div>
        </form>
    </div>

    {{-- Liens rapides --}}
    <div class="grid grid-cols-2 gap-4 mt-6">
        <a href="{{ route('admin.valeurs.index') }}"
           class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center gap-4
                  hover:border-blue-300 hover:shadow-md transition-all">
            <span class="text-3xl">💎</span>
            <div>
                <div class="font-bold text-gray-800 text-sm">Nos valeurs</div>
                <div class="text-xs text-gray-400">Gérer les valeurs</div>
            </div>
        </a>
        <a href="{{ route('admin.equipe.index') }}"
           class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center gap-4
                  hover:border-blue-300 hover:shadow-md transition-all">
            <span class="text-3xl">👥</span>
            <div>
                <div class="font-bold text-gray-800 text-sm">Équipe de direction</div>
                <div class="text-xs text-gray-400">Gérer les membres</div>
            </div>
        </a>
    </div>
</div>

@endsection