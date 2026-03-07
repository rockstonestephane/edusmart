@extends('admin.layouts.admin')
@section('title', 'Ajouter des photos')
@section('breadcrumb', 'Galerie → Ajouter')

@section('content')

<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.galerie.index') }}" class="btn-outline">← Retour</a>
    <h1 class="text-2xl font-bold text-gray-800">Ajouter des photos</h1>
</div>

<form method="POST" action="{{ route('admin.galerie.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">
                    Photos <span class="text-red-500">*</span>
                    <span class="text-gray-400 font-normal text-sm ml-2">
                        (vous pouvez sélectionner plusieurs photos à la fois)
                    </span>
                </h3>

                <label class="upload-zone block cursor-pointer" for="images-input">
                    <div id="preview-grid" class="hidden mb-4">
                        <div id="preview-container"
                             class="grid grid-cols-3 gap-2"></div>
                        <p id="preview-count"
                           class="text-xs text-gray-400 mt-2 text-center"></p>
                    </div>
                    <div id="upload-placeholder">
                        <div class="text-5xl mb-3">📸</div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">
                            Cliquez pour choisir vos photos
                        </p>
                        <p class="text-xs text-gray-400">JPG, PNG, WEBP — max 4 Mo par photo</p>
                        <p class="text-xs text-gray-400 mt-1">
                            Sélection multiple possible
                        </p>
                    </div>
                    <input type="file" id="images-input" name="images[]"
                           accept="image/*" multiple class="hidden"
                           onchange="previewImages(this)" required>
                </label>

                @error('images') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                @error('images.*') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="space-y-5">

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Informations</h3>

                <div class="mb-4">
                    <label class="form-label">Légende
                        <span class="text-gray-400 font-normal">(commune à toutes les photos)</span>
                    </label>
                    <input type="text" name="legende" value="{{ old('legende') }}"
                           class="form-input" placeholder="Ex : Cérémonie de remise des prix">
                </div>

                <div class="mb-4">
                    <label class="form-label">Catégorie</label>
                    <select name="categorie" class="form-select">
                        <option value="">-- Sans catégorie --</option>
                        @foreach(['Événements','Campus','Sport','Culture','Remises de prix','Vie scolaire'] as $cat)
                        <option value="{{ $cat }}" {{ old('categorie') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                    <div>
                        <div class="text-sm font-semibold text-gray-700">Afficher sur la home</div>
                        <div class="text-xs text-gray-400">Section galerie de l'accueil</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        {{-- Le champ hidden est OBLIGATOIRE : sans lui, si la checkbox est décochée,
                             aucune valeur n'est envoyée et homepage reste toujours false --}}
                        <input type="hidden" name="homepage" value="0">
                        <input type="checkbox" name="homepage" value="1" class="sr-only peer"
                               {{ old('homepage') ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-checked:bg-blue-600 rounded-full
                                    peer peer-checked:after:translate-x-full after:content-['']
                                    after:absolute after:top-[2px] after:left-[2px] after:bg-white
                                    after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-3">
                ✅ Enregistrer les photos
            </button>

        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
function previewImages(input) {
    const container = document.getElementById('preview-container');
    const grid      = document.getElementById('preview-grid');
    const holder    = document.getElementById('upload-placeholder');
    const count     = document.getElementById('preview-count');

    container.innerHTML = '';

    if (input.files && input.files.length > 0) {
        grid.classList.remove('hidden');
        holder.classList.add('hidden');
        count.textContent = input.files.length + ' photo(s) sélectionnée(s)';

        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-24 object-cover rounded-lg';
                container.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endpush