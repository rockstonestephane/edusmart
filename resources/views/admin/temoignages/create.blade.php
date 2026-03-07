@extends('admin.layouts.admin')
@section('title', 'Nouveau témoignage')
@section('breadcrumb', 'Témoignages → Nouveau')

@section('content')

<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.temoignages.index') }}" class="btn-outline">← Retour</a>
    <h1 class="text-2xl font-bold text-gray-800">Nouveau témoignage</h1>
</div>

<form method="POST" action="{{ route('admin.temoignages.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Contenu</h3>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="form-label">Nom complet <span class="text-red-500">*</span></label>
                        <input type="text" name="nom" value="{{ old('nom') }}"
                               class="form-input" placeholder="Ex : Sophie Martin" required>
                        @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label">Rôle <span class="text-red-500">*</span></label>
                        <input type="text" name="role" value="{{ old('role') }}"
                               class="form-input" placeholder="Ex : Parent d'élève" required>
                        @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Témoignage <span class="text-red-500">*</span></label>
                    <textarea name="texte" rows="4" class="form-textarea"
                              placeholder="Le témoignage..." required>{{ old('texte') }}</textarea>
                    @error('texte') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="form-label">Note <span class="text-red-500">*</span></label>
                    <div class="flex gap-3 mt-1">
                        @for($i = 1; $i <= 5; $i++)
                        <label class="flex items-center gap-1.5 cursor-pointer">
                            <input type="radio" name="note" value="{{ $i }}"
                                   {{ old('note', 5) == $i ? 'checked' : '' }}
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
                <h3 class="font-bold text-gray-700 mb-4">Photo
                    <span class="text-gray-400 font-normal">(optionnelle)</span>
                </h3>
                <label class="upload-zone block cursor-pointer" for="photo-input">
                    <div id="preview-container" class="hidden mb-3">
                        <img id="photo-preview" src="" alt="Aperçu"
                             class="w-20 h-20 object-cover rounded-full mx-auto">
                    </div>
                    <div id="upload-placeholder">
                        <div class="text-3xl mb-2">👤</div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">Photo du témoin</p>
                        <p class="text-xs text-gray-400">JPG, PNG — max 2 Mo</p>
                    </div>
                    <input type="file" id="photo-input" name="photo" accept="image/*"
                           class="hidden" onchange="previewPhoto(this)">
                </label>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">Paramètres</h3>

                <div class="mb-4">
                    <label class="form-label">Ordre</label>
                    <input type="number" name="ordre" value="{{ old('ordre', 1) }}"
                           min="0" class="form-input">
                </div>

                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                    <div>
                        <div class="text-sm font-semibold text-gray-700">Publié</div>
                        <div class="text-xs text-gray-400">Visible sur le site</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="publie" value="1" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-gray-200 peer-checked:bg-blue-600 rounded-full
                                    peer peer-checked:after:translate-x-full after:content-['']
                                    after:absolute after:top-[2px] after:left-[2px] after:bg-white
                                    after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-primary w-full justify-center py-3">
                ✅ Enregistrer
            </button>

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