@extends('admin.layouts.admin')
@section('title', 'Modifier formation')
@section('breadcrumb', 'Formations → Modifier')

@section('content')

<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.formations.index') }}" class="btn-outline">← Retour</a>
    <h1 class="text-2xl font-bold text-gray-800">Modifier la formation</h1>
</div>

<form method="POST" action="{{ route('admin.formations.update', $formation->id) }}"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-5">

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Informations</h3>

                <div class="mb-4">
                    <label class="form-label">Titre <span class="text-red-500">*</span></label>
                    <input type="text" name="titre"
                           value="{{ old('titre', $formation->titre) }}"
                           class="form-input" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Extrait <span class="text-red-500">*</span></label>
                    <textarea name="extrait" rows="2" class="form-textarea" required>{{ old('extrait', $formation->extrait) }}</textarea>
                </div>

                <div>
                    <label class="form-label">Contenu détaillé</label>
                    <textarea name="contenu" rows="8" class="form-textarea">{{ old('contenu', $formation->contenu) }}</textarea>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Apparence</h3>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="form-label">Icône (emoji)</label>
                        <input type="text" name="icon"
                               value="{{ old('icon', $formation->icon) }}"
                               class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Couleur gradient</label>
                        <select name="color" class="form-select">
                            @foreach([
                                'from-blue-500 to-blue-700'       => '🔵 Bleu',
                                'from-purple-500 to-purple-700'   => '🟣 Violet',
                                'from-emerald-500 to-emerald-700' => '🟢 Vert',
                                'from-orange-500 to-red-600'      => '🟠 Orange',
                                'from-sky-500 to-indigo-600'      => '🩵 Ciel',
                                'from-pink-500 to-rose-600'       => '🩷 Rose',
                                'from-blue-700 to-blue-900'       => '🔷 Bleu foncé',
                            ] as $val => $label)
                            <option value="{{ $val }}"
                                    {{ old('color', $formation->color) == $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="form-label">Tags <span class="text-gray-400 font-normal">(séparés par des virgules)</span></label>
                    <input type="text" name="tags"
                           value="{{ old('tags', implode(', ', $formation->tags ?? [])) }}"
                           class="form-input">
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Image</h3>
                @if($formation->image)
                <div class="mb-4">
                    <p class="text-xs text-gray-400 mb-2">Image actuelle :</p>
                    <img src="{{ Storage::url($formation->image) }}"
                         class="w-full h-40 object-cover rounded-xl">
                </div>
                @endif
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
                    <label class="form-label">Ordre d'affichage</label>
                    <input type="number" name="ordre"
                           value="{{ old('ordre', $formation->ordre) }}"
                           min="0" class="form-input">
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                    <div>
                        <div class="text-sm font-semibold text-gray-700">Active</div>
                        <div class="text-xs text-gray-400">Visible sur le site</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="active" value="1"
                               class="sr-only peer" {{ $formation->active ? 'checked' : '' }}>
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

            <form method="POST" action="{{ route('admin.formations.destroy', $formation->id) }}"
                  onsubmit="return confirm('Supprimer cette formation ?')">
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