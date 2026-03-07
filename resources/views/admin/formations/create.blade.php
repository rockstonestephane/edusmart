@extends('admin.layouts.admin')
@section('title', 'Nouvelle formation')
@section('breadcrumb', 'Formations → Nouvelle')

@section('content')

<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.formations.index') }}" class="btn-outline">← Retour</a>
    <h1 class="text-2xl font-bold text-gray-800">Nouvelle formation</h1>
</div>

<form method="POST" action="{{ route('admin.formations.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-5">

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Informations</h3>

                <div class="mb-4">
                    <label class="form-label">Titre <span class="text-red-500">*</span></label>
                    <input type="text" name="titre" value="{{ old('titre') }}"
                           class="form-input @error('titre') border-red-400 @enderror"
                           placeholder="Ex : Cycle Primaire" required>
                    @error('titre') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label">Extrait <span class="text-red-500">*</span>
                        <span class="text-gray-400 font-normal">(affiché sur la carte)</span>
                    </label>
                    <textarea name="extrait" rows="2" class="form-textarea"
                              placeholder="Description courte..." required>{{ old('extrait') }}</textarea>
                    @error('extrait') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Contenu détaillé
                        <span class="text-gray-400 font-normal">(page détail de la formation)</span>
                    </label>
                    <textarea name="contenu" rows="8" class="form-textarea"
                              placeholder="Description complète...">{{ old('contenu') }}</textarea>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Apparence</h3>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="form-label">Icône (emoji)</label>
                        <input type="text" name="icon" value="{{ old('icon', '📚') }}"
                               class="form-input" placeholder="Ex : 🎒">
                        <p class="text-xs text-gray-400 mt-1">Copiez un emoji directement</p>
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
                            <option value="{{ $val }}" {{ old('color') == $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="form-label">Tags
                        <span class="text-gray-400 font-normal">(séparés par des virgules)</span>
                    </label>
                    <input type="text" name="tags" value="{{ old('tags') }}"
                           class="form-input"
                           placeholder="Ex : CP – CM2, Bilingue, Sport">
                    <p class="text-xs text-gray-400 mt-1">Ex : CP – CM2, Bilingue, Sport</p>
                </div>
            </div>

            {{-- Image optionnelle --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Image
                    <span class="text-gray-400 font-normal text-sm">(optionnelle)</span>
                </h3>
                <label class="upload-zone block cursor-pointer" for="image-input">
                    <div id="preview-container" class="hidden mb-4">
                        <img id="image-preview" src="" alt="Aperçu"
                             class="w-full h-40 object-cover rounded-xl">
                    </div>
                    <div id="upload-placeholder">
                        <div class="text-4xl mb-3">🖼️</div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">Cliquez pour choisir une image</p>
                        <p class="text-xs text-gray-400">JPG, PNG, WEBP — max 4 Mo</p>
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
                    <input type="number" name="ordre" value="{{ old('ordre', 1) }}"
                           min="0" class="form-input">
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                    <div>
                        <div class="text-sm font-semibold text-gray-700">Active</div>
                        <div class="text-xs text-gray-400">Visible sur le site</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="active" value="1" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-checked:bg-blue-600 rounded-full
                                    peer peer-checked:after:translate-x-full after:content-['']
                                    after:absolute after:top-[2px] after:left-[2px] after:bg-white
                                    after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-3">
                ✅ Enregistrer la formation
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