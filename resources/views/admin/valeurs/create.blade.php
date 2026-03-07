@extends('admin.layouts.admin')
@section('title', 'Nouvelle valeur')
@section('breadcrumb', 'Nouvelle valeur')

@section('content')

<div class="max-w-xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 p-8">
        <h1 class="text-xl font-bold text-gray-800 mb-6">Nouvelle valeur</h1>

        <form method="POST" action="{{ route('admin.valeurs.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Icône (emoji)</label>
                <input type="text" name="icone" maxlength="10"
                       value="{{ old('icone') }}"
                       placeholder="ex: 🎯"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2 text-2xl
                              focus:ring-2 focus:ring-blue-500 focus:outline-none">
                <p class="text-xs text-gray-400 mt-1">Appuyez sur Win+. pour ouvrir le panneau emoji</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Titre <span class="text-red-500">*</span></label>
                <input type="text" name="titre" required maxlength="100"
                       value="{{ old('titre') }}"
                       placeholder="ex: Excellence"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2
                              focus:ring-2 focus:ring-blue-500 focus:outline-none">
                @error('titre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
                <textarea name="description" required rows="3" maxlength="500"
                          placeholder="ex: Nous visons le meilleur dans tout ce que nous faisons..."
                          class="w-full border border-gray-200 rounded-xl px-4 py-2
                                 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Couleur du gradient</label>
                <select name="couleur"
                        class="w-full border border-gray-200 rounded-xl px-4 py-2
                               focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    @foreach([
                        'from-blue-500 to-blue-700'       => '🔵 Bleu',
                        'from-purple-500 to-purple-700'   => '🟣 Violet',
                        'from-emerald-500 to-emerald-700' => '🟢 Vert',
                        'from-orange-500 to-red-500'      => '🟠 Orange',
                        'from-sky-500 to-indigo-600'      => '🔷 Bleu ciel',
                        'from-pink-500 to-rose-600'       => '🩷 Rose',
                        'from-yellow-500 to-orange-500'   => '🟡 Jaune',
                    ] as $value => $label)
                    <option value="{{ $value }}" {{ old('couleur') === $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
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
                <a href="{{ route('admin.valeurs.index') }}" class="btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

@endsection