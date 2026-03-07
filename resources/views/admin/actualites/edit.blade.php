@extends('admin.layouts.admin')
@section('title', 'Modifier actualité')
@section('breadcrumb', 'Actualités → Modifier')

@section('content')

<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.actualites.index') }}" class="btn-outline">← Retour</a>
    <h1 class="text-2xl font-bold text-gray-800">Modifier l'actualité</h1>
</div>

<form method="POST" action="{{ route('admin.actualites.update', $actualite->id) }}"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-5">

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Contenu</h3>

                <div class="mb-4">
                    <label class="form-label">Titre <span class="text-red-500">*</span></label>
                    <input type="text" name="titre"
                           value="{{ old('titre', $actualite->titre) }}"
                           class="form-input" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Extrait <span class="text-red-500">*</span></label>
                    <textarea name="extrait" rows="2" class="form-textarea" required>{{ old('extrait', $actualite->extrait) }}</textarea>
                </div>

                <div>
                    <label class="form-label">Contenu complet <span class="text-red-500">*</span></label>
                    <textarea name="contenu" rows="10" class="form-textarea" required>{{ old('contenu', $actualite->contenu) }}</textarea>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Image</h3>
                <div class="mb-4">
                    <p class="text-xs text-gray-400 mb-2">Image actuelle :</p>
                    <img src="{{ Storage::url($actualite->image) }}"
                         class="w-full h-40 object-cover rounded-xl">
                </div>
                <label class="upload-zone block cursor-pointer" for="image-input">
                    <div id="preview-container" class="hidden mb-4">
                        <img id="image-preview" src="" alt="Aperçu"
                             class="w-full h-40 object-cover rounded-xl">
                    </div>
                    <div id="upload-placeholder">
                        <div class="text-3xl mb-2">🔄</div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">Changer l'image</p>
                        <p class="text-xs text-gray-400">Laisser vide pour garder l'image actuelle</p>
                    </div>
                    <input type="file" id="image-input" name="image" accept="image/*"
                           class="hidden" onchange="previewImage(this)">
                </label>
            </div>

        </div>

        <div class="space-y-5">

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Paramètres</h3>

                <div class="mb-4">
                    <label class="form-label">Catégorie <span class="text-red-500">*</span></label>
                    <select name="categorie" class="form-select" required>
                        @foreach(['Événement','Résultats','Infrastructure','Pédagogie','Sport','Culture','Annonce'] as $cat)
                        <option value="{{ $cat }}"
                                {{ old('categorie', $actualite->categorie) == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                    <div>
                        <div class="text-sm font-semibold text-gray-700">Publier</div>
                        <div class="text-xs text-gray-400">Visible sur le site</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="publiee" value="1"
                               class="sr-only peer" {{ $actualite->publiee ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-checked:bg-blue-600 rounded-full
                                    peer peer-checked:after:translate-x-full after:content-['']
                                    after:absolute after:top-[2px] after:left-[2px] after:bg-white
                                    after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-3">
                ✅ Mettre à jour
            </button>

            <form method="POST" action="{{ route('admin.actualites.destroy', $actualite->id) }}"
                  onsubmit="return confirm('Supprimer cette actualité ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger w-full justify-center py-3">
                    🗑️ Supprimer
                </button>
            </form>

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