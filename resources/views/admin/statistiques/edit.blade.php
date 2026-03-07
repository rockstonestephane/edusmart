@extends('admin.layouts.admin')
@section('title', 'Modifier la statistique')
@section('breadcrumb', 'Modifier la statistique')

@section('content')

<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 p-8">
        <h1 class="text-xl font-bold text-gray-800 mb-6">Modifier la statistique</h1>

        <form method="POST" action="{{ route('admin.statistiques.update', $statistique->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Icône (emoji)</label>
                <input type="text" name="icone" maxlength="10"
                       value="{{ old('icone', $statistique->icone) }}"
                       placeholder="ex: 🎓"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2 text-2xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <p class="text-xs text-gray-400 mt-1">Collez un emoji directement (ex: 🎓 🏛️ 🏆)</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Valeur <span class="text-red-500">*</span></label>
                <input type="text" name="valeur" required maxlength="20"
                       value="{{ old('valeur', $statistique->valeur) }}"
                       placeholder="ex: 2500"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('valeur') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Suffixe</label>
                <input type="text" name="suffixe" maxlength="10"
                       value="{{ old('suffixe', $statistique->suffixe) }}"
                       placeholder="ex: + ou % ou ans"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <p class="text-xs text-gray-400 mt-1">Affiché après la valeur (ex: 2500<strong>+</strong>)</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Label <span class="text-red-500">*</span></label>
                <input type="text" name="label" required maxlength="100"
                       value="{{ old('label', $statistique->label) }}"
                       placeholder="ex: Élèves inscrits"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('label') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Ordre d'affichage</label>
                <input type="number" name="ordre" min="0"
                       value="{{ old('ordre', $statistique->ordre) }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="mb-6 flex items-center gap-3">
                <input type="hidden" name="actif" value="0">
                <input type="checkbox" name="actif" value="1" id="actif"
                       {{ $statistique->actif ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 rounded">
                <label for="actif" class="text-sm text-gray-700">Afficher sur le site</label>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="btn-primary">💾 Enregistrer</button>
                <a href="{{ route('admin.statistiques.index') }}" class="btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection