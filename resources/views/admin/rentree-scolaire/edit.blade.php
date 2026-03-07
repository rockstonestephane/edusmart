@extends('admin.layouts.admin')
@section('title', 'Modifier la rentrée scolaire')
@section('breadcrumb', 'Modifier la rentrée scolaire')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 p-8">
        <h1 class="text-xl font-bold text-gray-800 mb-6">Modifier la rentrée scolaire</h1>

        <form method="POST" action="{{ route('admin.rentree-scolaire.update', $rentreeScolaire->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Année scolaire <span class="text-red-500">*</span></label>
                <input type="text" name="annee" required maxlength="20"
                       value="{{ old('annee', $rentreeScolaire->annee) }}"
                       placeholder="ex: 2025-2026"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('annee') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Badge / Étiquette</label>
                <input type="text" name="badge_label" maxlength="60"
                       value="{{ old('badge_label', $rentreeScolaire->badge_label) }}"
                       placeholder="ex: INSCRIPTIONS OUVERTES"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Titre <span class="text-red-500">*</span></label>
                <input type="text" name="titre" required maxlength="200"
                       value="{{ old('titre', $rentreeScolaire->titre) }}"
                       placeholder="ex: Préparez la rentrée"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('titre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3" maxlength="500"
                          placeholder="ex: Complétez votre dossier de préinscription en ligne en moins de 5 minutes."
                          class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('description', $rentreeScolaire->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bouton 1 — Texte</label>
                    <input type="text" name="btn1_label" maxlength="60"
                           value="{{ old('btn1_label', $rentreeScolaire->btn1_label) }}"
                           placeholder="ex: Déposer ma candidature"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bouton 1 — Lien</label>
                    <input type="text" name="btn1_url" maxlength="200"
                           value="{{ old('btn1_url', $rentreeScolaire->btn1_url) }}"
                           placeholder="ex: /preinscription"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bouton 2 — Texte</label>
                    <input type="text" name="btn2_label" maxlength="60"
                           value="{{ old('btn2_label', $rentreeScolaire->btn2_label) }}"
                           placeholder="ex: Nous contacter"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bouton 2 — Lien</label>
                    <input type="text" name="btn2_url" maxlength="200"
                           value="{{ old('btn2_url', $rentreeScolaire->btn2_url) }}"
                           placeholder="ex: /contact"
                           class="w-full border border-gray-200 rounded-xl px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>
            </div>

            <div class="mb-6 flex items-center gap-3">
                <input type="hidden" name="actif" value="0">
                <input type="checkbox" name="actif" value="1" id="actif"
                       {{ $rentreeScolaire->actif ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 rounded">
                <label for="actif" class="text-sm text-gray-700">Afficher sur le site (désactive les autres)</label>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="btn-primary">💾 Enregistrer</button>
                <a href="{{ route('admin.rentree-scolaire.index') }}" class="btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection