@extends('admin.layouts.admin')
@section('title', 'Modifier témoignage')
@section('breadcrumb', 'Témoignages → Modifier')

@section('content')

<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.temoignages.index') }}" class="btn-outline">← Retour</a>
    <h1 class="text-2xl font-bold text-gray-800">Modifier le témoignage</h1>
</div>

<form method="POST" action="{{ route('admin.temoignages.update', $temoignage->id) }}"
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Contenu</h3>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="form-label">Nom complet <span class="text-red-500">*</span></label>
                        <input type="text" name="nom"
                               value="{{ old('nom', $temoignage->nom) }}"
                               class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Rôle <span class="text-red-500">*</span></label>
                        <input type="text" name="role"
                               value="{{ old('role', $temoignage->role) }}"
                               class="form-input" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Témoignage <span class="text-red-500">*</span></label>
                    <textarea name="texte" rows="4" class="form-textarea" required>{{ old('texte', $temoignage->texte) }}</textarea>
                </div>

                <div>
                    <label class="form-label">Note</label>
                    <div class="flex gap-3 mt-1">
                        @for($i = 1; $i <= 5; $i++)
                        <label class="flex items-center gap-1.5 cursor-pointer">
                            <input type="radio" name="note" value="{{ $i }}"
                                   {{ old('note', $temoignage->note) == $i ? 'checked' : '' }}
                                   class="accent-yellow-400">
                            <span class="text-yellow-400 text-xl">{{ str_repeat('★', $i) }}</span>
                        </label>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-5">

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Photo</h3>

                @if($temoignage->photo)
                <div class="text-center mb-3">
                    <img src="{{ Storage::url($temoignage->photo) }}"
                         class="w-16 h-16 rounded-full object-cover mx-auto">
                    <p class="text-xs text-gray-400 mt-1">Photo actuelle</p>
                </div>
                @endif

                <label class="upload-zone block cursor-pointer" for="photo-input">
                    <div id="preview-container" class="hidden mb-3">
                        <img id="photo-preview" src="" alt="Aperçu"
                             class="w-16 h-16 object-cover rounded-full mx-auto">
                    </div>
                    <div id="upload-placeholder">
                        <div class="text-2xl mb-1">🔄</div>
                        <p class="text-xs font-semibold text-gray-600">Changer la photo</p>
                        <p class="text-xs text-gray-400">Laisser vide pour garder</p>
                    </div>
                    <input type="file" id="photo-input" name="photo" accept="image/*"
                           class="hidden" onchange="previewPhoto(this)">
                </label>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Paramètres</h3>

                <div class="mb-4">
                    <label class="form-label">Ordre</label>
                    <input type="number" name="ordre"
                           value="{{ old('ordre', $temoignage->ordre) }}"
                           min="0" class="form-input">
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                    <div>
                        <div class="text-sm font-semibold text-gray-700">Publié</div>
                        <div class="text-xs text-gray-400">Visible sur le site</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="publie" value="1"
                               class="sr-only peer" {{ $temoignage->publie ? 'checked' : '' }}>
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

            <form method="POST" action="{{ route('admin.temoignages.destroy', $temoignage->id) }}"
                  onsubmit="return confirm('Supprimer ce témoignage ?')">
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
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('photo-preview').src = e.target.result;
            document.getElementById('preview-container').classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush