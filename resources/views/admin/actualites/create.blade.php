@extends('admin.layouts.admin')
@section('title', 'Nouvelle actualité')
@section('breadcrumb', 'Actualités → Nouvelle')

@section('content')

<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.actualites.index') }}" class="btn-outline">← Retour</a>
    <h1 class="text-2xl font-bold text-gray-800">Nouvelle actualité</h1>
</div>

<form method="POST" action="{{ route('admin.actualites.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-5">

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Contenu</h3>

                <div class="mb-4">
                    <label class="form-label">Titre <span class="text-red-500">*</span></label>
                    <input type="text" name="titre" value="{{ old('titre') }}"
                           class="form-input @error('titre') border-red-400 @enderror"
                           placeholder="Titre de l'actualité" required>
                    @error('titre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Extrait <span class="text-red-500">*</span>
                        <span class="text-gray-400 font-normal">(résumé court affiché sur la liste)</span>
                    </label>
                    <textarea name="extrait" rows="2"
                              class="form-textarea @error('extrait') border-red-400 @enderror"
                              placeholder="Résumé en 1-2 phrases..." required>{{ old('extrait') }}</textarea>
                    @error('extrait') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Contenu complet <span class="text-red-500">*</span></label>
                    <textarea name="contenu" rows="10"
                              class="form-textarea @error('contenu') border-red-400 @enderror"
                              placeholder="Rédigez le contenu complet de l'actualité..." required>{{ old('contenu') }}</textarea>
                    @error('contenu') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">
                    Image <span class="text-red-500">*</span>
                </h3>
                <label class="upload-zone block cursor-pointer" for="image-input">
                    <div id="preview-container" class="hidden mb-4">
                        <img id="image-preview" src="" alt="Aperçu"
                             class="w-full h-48 object-cover rounded-xl">
                    </div>
                    <div id="upload-placeholder">
                        <div class="text-4xl mb-3">📷</div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">Cliquez pour choisir une image</p>
                        <p class="text-xs text-gray-400">JPG, PNG, WEBP — max 4 Mo</p>
                    </div>
                    <input type="file" id="image-input" name="image" accept="image/*"
                           class="hidden" required onchange="previewImage(this)">
                </label>
                @error('image') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
            </div>

        </div>

        <div class="space-y-5">

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Paramètres</h3>

                <div class="mb-4">
                    <label class="form-label">Catégorie <span class="text-red-500">*</span></label>
                    <select name="categorie" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        @foreach(['Événement','Résultats','Infrastructure','Pédagogie','Sport','Culture','Annonce'] as $cat)
                        <option value="{{ $cat }}" {{ old('categorie') == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                        @endforeach
                    </select>
                    @error('categorie') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                    <div>
                        <div class="text-sm font-semibold text-gray-700">Publier</div>
                        <div class="text-xs text-gray-400">Visible sur le site</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="publiee" value="1" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-checked:bg-blue-600 rounded-full
                                    peer peer-checked:after:translate-x-full after:content-['']
                                    after:absolute after:top-[2px] after:left-[2px] after:bg-white
                                    after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-3">
                ✅ Publier l'actualité
            </button>

        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('image-preview').src = e.target.result;
            document.getElementById('preview-container').classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush