@extends('admin.layouts.admin')
@section('title', 'Mot du Directeur')
@section('breadcrumb', 'Mot du Directeur')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Mot du Directeur</h1>
        <p class="text-sm text-gray-500 mt-1">Gérez le message et les informations du directeur affiché sur la page À propos.</p>
    </div>
</div>

{{-- Alerte succès --}}
@if(session('success'))
<div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl">
    <span class="text-xl">✅</span>
    <span class="text-sm font-medium">{{ session('success') }}</span>
</div>
@endif

{{-- Erreurs de validation --}}
@if($errors->any())
<div class="mb-6 flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl">
    <span class="text-xl">❌</span>
    <ul class="text-sm list-disc list-inside">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('admin.mot-directeur.update') }}" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Colonne principale (2/3) ── --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Informations --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h2 class="text-base font-bold text-gray-700 mb-5">👤 Informations du directeur</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    {{-- Nom --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nom complet <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nom" value="{{ old('nom', $motDirecteur->nom) }}"
                               placeholder="Ex : Dr. Jean MBARGA"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400
                                      @error('nom') border-red-400 @enderror">
                        @error('nom')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Poste --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Poste / Titre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="poste" value="{{ old('poste', $motDirecteur->poste) }}"
                               placeholder="Ex : Directeur Général"
                               class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400
                                      @error('poste') border-red-400 @enderror">
                        @error('poste')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Message --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h2 class="text-base font-bold text-gray-700 mb-5">✍️ Message du directeur</h2>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Texte / Discours <span class="text-red-500">*</span>
                    </label>
                    <textarea name="texte" rows="10"
                              placeholder="Saisissez ici le message du directeur..."
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm leading-relaxed
                                     focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400
                                     resize-y @error('texte') border-red-400 @enderror">{{ old('texte', $motDirecteur->texte) }}</textarea>
                    @error('texte')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

        </div>

        {{-- ── Colonne latérale (1/3) ── --}}
        <div class="space-y-6">

            {{-- Photo --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h2 class="text-base font-bold text-gray-700 mb-5">📷 Photo du directeur</h2>

                {{-- Prévisualisation actuelle --}}
                @if($motDirecteur->photo)
                <div class="mb-4 text-center">
                    <img src="{{ Storage::url($motDirecteur->photo) }}"
                         alt="Photo actuelle"
                         class="w-28 h-28 rounded-full object-cover mx-auto shadow-md
                                border-4 border-white ring-2 ring-blue-100">
                    <p class="text-xs text-gray-400 mt-2">Photo actuelle</p>
                </div>
                @else
                <div class="mb-4 flex items-center justify-center">
                    <div class="w-28 h-28 rounded-full flex items-center justify-center text-4xl
                                font-bold text-white shadow-md"
                         style="background:linear-gradient(135deg,#2952f5,#152dd4)">
                        {{ $motDirecteur->nom ? mb_substr($motDirecteur->nom, 0, 1) : '?' }}
                    </div>
                </div>
                @endif

                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    {{ $motDirecteur->photo ? 'Changer la photo' : 'Ajouter une photo' }}
                </label>
                <input type="file" name="photo" accept="image/*"
                       class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4
                              file:rounded-lg file:border-0 file:text-sm file:font-semibold
                              file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100
                              @error('photo') border border-red-400 rounded-xl @enderror">
                <p class="text-xs text-gray-400 mt-2">JPEG, PNG, WebP — max 2 Mo</p>
                @error('photo')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Signature --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h2 class="text-base font-bold text-gray-700 mb-5">🖊️ Signature <span class="text-gray-400 font-normal text-xs">(optionnel)</span></h2>

                @if($motDirecteur->signature)
                <div class="mb-4 text-center bg-gray-50 rounded-xl p-3">
                    <img src="{{ Storage::url($motDirecteur->signature) }}"
                         alt="Signature actuelle"
                         class="h-14 mx-auto object-contain">
                    <p class="text-xs text-gray-400 mt-2">Signature actuelle</p>
                </div>
                @endif

                <input type="file" name="signature" accept="image/*"
                       class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4
                              file:rounded-lg file:border-0 file:text-sm file:font-semibold
                              file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100
                              @error('signature') border border-red-400 rounded-xl @enderror">
                <p class="text-xs text-gray-400 mt-2">Image PNG avec fond transparent recommandée — max 1 Mo</p>
                @error('signature')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Bouton sauvegarder --}}
            <button type="submit"
                    class="btn-primary w-full justify-center py-3 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M5 13l4 4L19 7"/>
                </svg>
                Enregistrer les modifications
            </button>

        </div>
    </div>

</form>

@endsection