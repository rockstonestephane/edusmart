@extends('admin.layouts.admin')
@section('title', 'Nouveau membre')
@section('breadcrumb', 'Nouveau membre')

@section('content')

<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 p-8">
        <h1 class="text-xl font-bold text-gray-800 mb-6">Nouveau membre</h1>

        <form method="POST"
              action="{{ route('admin.equipe.store') }}"
              enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Photo</label>
                <input type="file" name="photo" accept="image/*"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2 text-sm
                              focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP — max 2Mo (optionnel)</p>
                @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet <span class="text-red-500">*</span></label>
                <input type="text" name="nom" required maxlength="100"
                       value="{{ old('nom') }}"
                       placeholder="ex: Dr. Jean MBARGA"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2
                              focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Poste <span class="text-red-500">*</span></label>
                <input type="text" name="poste" required maxlength="100"
                       value="{{ old('poste') }}"
                       placeholder="ex: Directeur Général"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2
                              focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('poste') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Biographie</label>
                <textarea name="bio" rows="3" maxlength="500"
                          placeholder="ex: Docteur en Sciences de l'Éducation, 25 ans d'expérience..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-2
                                 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('bio') }}</textarea>
                @error('bio') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Ordre d'affichage</label>
                <input type="number" name="ordre" min="0"
                       value="{{ old('ordre', 1) }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2
                              focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="mb-6 flex items-center gap-3">
                <input type="hidden" name="actif" value="0">
                <input type="checkbox" name="actif" value="1" id="actif" checked
                       class="w-4 h-4 text-blue-600 rounded">
                <label for="actif" class="text-sm text-gray-700">Afficher sur le site</label>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="btn-primary">✅ Créer</button>
                <a href="{{ route('admin.equipe.index') }}" class="btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection