@extends('admin.layouts.admin')
@section('title', 'Nouvelle statistique')
@section('breadcrumb', 'Nouvelle statistique')

@section('content')

<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 p-8">
        <h1 class="text-xl font-bold text-gray-800 mb-6">Nouvelle statistique</h1>

        <form method="POST" action="{{ route('admin.statistiques.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Icône (emoji)</label>
                <input type="text" name="icone" maxlength="10"
                       value="{{ old('icone') }}"
                       placeholder="ex: 🎓"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2 text-2xl focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <p class="text-xs text-gray-400 mt-1">Collez un emoji directement (ex: 🎓 🏛️ 🏆)</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Valeur <span class="text-red-500">*</span></label>
                <input type="text" name="valeur" required maxlength="20"
                       value="{{ old('valeur') }}"
                       placeholder="ex: 2500"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('valeur') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Suffixe</label>
                <input type="text" name="suffixe" maxlength="10"
                       value="{{ old('suffixe') }}"
                       placeholder="ex: + ou % ou ans"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <p class="text-xs text-gray-400 mt-1">Affiché après la valeur (ex: 2500<strong>+</strong>)</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Label <span class="text-red-500">*</span></label>
                <input type="text" name="label" required maxlength="100"
                       value="{{ old('label') }}"
                       placeholder="ex: Élèves inscrits"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('label') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Ordre d'affichage</label>
                <input type="number" name="ordre" min="0"
                       value="{{ old('ordre', 1) }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="mb-6 flex items-center gap-3">
                <input type="hidden" name="actif" value="0">
                <input type="checkbox" name="actif" value="1" id="actif" checked
                       class="w-4 h-4 text-blue-600 rounded">
                <label for="actif" class="text-sm text-gray-700">Afficher sur le site</label>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="btn-primary">✅ Créer</button>
                <a href="{{ route('admin.statistiques.index') }}" class="btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection