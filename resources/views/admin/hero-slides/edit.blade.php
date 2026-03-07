@extends('admin.layouts.admin')
@section('title', 'Modifier le slide')
@section('breadcrumb', 'Hero Slides → Modifier')

@section('content')

<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.hero-slides.index') }}" class="btn-outline">← Retour</a>
    <h1 class="text-2xl font-bold text-gray-800">Modifier le slide</h1>
</div>

<form method="POST" action="{{ route('admin.hero-slides.update', $heroSlide->id) }}"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 space-y-5">

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Textes du slide</h3>

                <div class="mb-4">
                    <label class="form-label">Surtitre</label>
                    <input type="text" name="surtitre"
                           value="{{ old('surtitre', $heroSlide->surtitre) }}"
                           class="form-input">
                </div>

                <div class="mb-4">
                    <label class="form-label">Titre principal <span class="text-red-500">*</span></label>
                    <input type="text" name="titre"
                           value="{{ old('titre', $heroSlide->titre) }}"
                           class="form-input" required>
                </div>

                <div>
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="3"
                              class="form-textarea">{{ old('description', $heroSlide->description) }}</textarea>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Boutons d'action</h3>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="form-label">Bouton 1 — Texte</label>
                        <input type="text" name="btn1_label"
                               value="{{ old('btn1_label', $heroSlide->btn1_label) }}"
                               class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Bouton 1 — Lien</label>
                        <input type="text" name="btn1_url"
                               value="{{ old('btn1_url', $heroSlide->btn1_url) }}"
                               class="form-input">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="form-label">Bouton 2 — Texte</label>
                        <input type="text" name="btn2_label"
                               value="{{ old('btn2_label', $heroSlide->btn2_label) }}"
                               class="form-input">
                    </div>
                    <div>
                        <label class="form-label">Bouton 2 — Lien</label>
                        <input type="text" name="btn2_url"
                               value="{{ old('btn2_url', $heroSlide->btn2_url) }}"
                               class="form-input">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Image de fond</h3>

                {{-- Image actuelle --}}
                <div class="mb-4">
                    <p class="text-xs text-gray-400 mb-2">Image actuelle :</p>
                    <img src="{{ Storage::url($heroSlide->image) }}"
                         alt="Image actuelle"
                         class="w-full h-40 object-cover rounded-xl">
                </div>

                {{-- Nouvelle image --}}
                <label class="upload-zone block cursor-pointer" for="image-input">
                    <div id="preview-container" class="hidden mb-4">
                        <img id="image-preview" src="" alt="Aperçu"
                             class="w-full h-40 object-cover rounded-xl">
                    </div>
                    <div id="upload-placeholder">
                        <div class="text-3xl mb-2">🔄</div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">
                            Cliquez pour changer l'image
                        </p>
                        <p class="text-xs text-gray-400">Laisser vide pour garder l'image actuelle</p>
                    </div>
                    <input type="file" id="image-input" name="image"
                           accept="image/*" class="hidden"
                           onchange="previewImage(this)">
                </label>
            </div>

        </div>

        <div class="space-y-5">

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Paramètres</h3>

                <div class="mb-4">
                    <label class="form-label">Ordre d'affichage</label>
                    <input type="number" name="ordre"
                           value="{{ old('ordre', $heroSlide->ordre) }}"
                           min="0" class="form-input">
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                    <div>
                        <div class="text-sm font-semibold text-gray-700">Slide actif</div>
                        <div class="text-xs text-gray-400">Visible sur le site</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="actif" value="1"
                               class="sr-only peer"
                               {{ $heroSlide->actif ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-checked:bg-blue-600
                                    rounded-full peer peer-checked:after:translate-x-full
                                    after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                    after:bg-white after:rounded-full after:h-5 after:w-5
                                    after:transition-all"></div>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-3">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Mettre à jour
            </button>

            <form method="POST"
                  action="{{ route('admin.hero-slides.destroy', $heroSlide->id) }}"
                  onsubmit="return confirm('Supprimer ce slide définitivement ?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger w-full justify-center py-3">
                    🗑️ Supprimer ce slide
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