@extends('admin.layouts.admin')
@section('title', 'Modifier photo')
@section('breadcrumb', 'Galerie → Modifier')

@section('content')

<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.galerie.index') }}" class="btn-outline">← Retour</a>
    <h1 class="text-2xl font-bold text-gray-800">Modifier la photo</h1>
</div>

<form method="POST" action="{{ route('admin.galerie.update', $galerie->id) }}"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-5">

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Photo actuelle</h3>
                <img src="{{ Storage::url($galerie->image) }}"
                     class="w-full h-64 object-cover rounded-xl mb-4">

                <label class="upload-zone block cursor-pointer" for="image-input">
                    <div id="preview-container" class="hidden mb-4">
                        <img id="image-preview" src="" alt="Aperçu"
                             class="w-full h-48 object-cover rounded-xl">
                    </div>
                    <div id="upload-placeholder">
                        <div class="text-3xl mb-2">🔄</div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">Changer la photo</p>
                        <p class="text-xs text-gray-400">Laisser vide pour garder la photo actuelle</p>
                    </div>
                    <input type="file" id="image-input" name="image" accept="image/*"
                           class="hidden" onchange="previewImage(this)">
                </label>
            </div>

        </div>

        <div class="space-y-5">

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Informations</h3>

                <div class="mb-4">
                    <label class="form-label">Légende</label>
                    <input type="text" name="legende"
                           value="{{ old('legende', $galerie->legende) }}"
                           class="form-input">
                </div>

                <div class="mb-4">
                    <label class="form-label">Catégorie</label>
                    <select name="categorie" class="form-select">
                        <option value="">-- Sans catégorie --</option>
                        @foreach(['Événements','Campus','Sport','Culture','Remises de prix','Vie scolaire'] as $cat)
                        <option value="{{ $cat }}"
                                {{ old('categorie', $galerie->categorie) == $cat ? 'selected' : '' }}>
                            {{ $cat }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Ordre</label>
                    <input type="number" name="ordre"
                           value="{{ old('ordre', $galerie->ordre) }}"
                           min="0" class="form-input">
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                    <div>
                        <div class="text-sm font-semibold text-gray-700">Sur la home</div>
                        <div class="text-xs text-gray-400">Section galerie accueil</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        {{-- Le champ hidden est OBLIGATOIRE : sans lui, si la checkbox est décochée,
                             aucune valeur n'est envoyée et homepage reste toujours false --}}
                        <input type="hidden" name="homepage" value="0">
                        <input type="checkbox" name="homepage" value="1"
                               class="sr-only peer"
                               {{ old('homepage', $galerie->homepage) ? 'checked' : '' }}>
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

            <form method="POST" action="{{ route('admin.galerie.destroy', $galerie->id) }}"
                  onsubmit="return confirm('Supprimer cette photo ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger w-full justify-center py-3">
                    🗑️ Supprimer la photo
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