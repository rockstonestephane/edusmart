@extends('admin.layouts.admin')
@section('title', 'Paramètres école')
@section('breadcrumb', 'Paramètres école')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Paramètres de l'école</h1>
    <p class="text-sm text-gray-500 mt-1">
        Toutes les modifications sont appliquées immédiatement sur le site.
    </p>
</div>

<form method="POST" action="{{ route('admin.parametres.update') }}"
      enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── Colonne principale ── --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- Identité --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4 flex items-center gap-2">
                    🏫 Identité de l'établissement
                </h3>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="form-label">Nom de l'école <span class="text-red-500">*</span></label>
                        <input type="text" name="school_name"
                               value="{{ old('school_name', env('SCHOOL_NAME', config('school.name'))) }}"
                               class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Slogan</label>
                        <input type="text" name="school_slogan"
                               value="{{ old('school_slogan', env('SCHOOL_SLOGAN', config('school.slogan'))) }}"
                               class="form-input" placeholder="School of Excellence">
                    </div>
                </div>
                <div>
                    <label class="form-label">Description
                        <span class="text-gray-400 font-normal">(meta + footer)</span>
                    </label>
                    <textarea name="school_description" rows="3" class="form-textarea"
                              placeholder="Description courte de l'établissement...">{{ old('school_description', env('SCHOOL_DESC', config('school.description'))) }}</textarea>
                </div>
            </div>

            {{-- Coordonnées --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4 flex items-center gap-2">
                    📍 Coordonnées
                </h3>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="form-label">Téléphone principal</label>
                        <input type="text" name="school_phone"
                               value="{{ old('school_phone', env('SCHOOL_PHONE', config('school.phone'))) }}"
                               class="form-input" placeholder="+237 222 00 00 00">
                    </div>
                    <div>
                        <label class="form-label">Téléphone secondaire</label>
                        <input type="text" name="school_phone2"
                               value="{{ old('school_phone2', env('SCHOOL_PHONE2', config('school.phone2'))) }}"
                               class="form-input" placeholder="Optionnel">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="form-label">Email</label>
                        <input type="email" name="school_email"
                               value="{{ old('school_email', env('SCHOOL_EMAIL', config('school.email'))) }}"
                               class="form-input" placeholder="contact@ecole.cm">
                    </div>
                    <div>
                        <label class="form-label">Site web</label>
                        <input type="text" name="school_website"
                               value="{{ old('school_website', env('SCHOOL_WEBSITE', config('school.website'))) }}"
                               class="form-input" placeholder="https://...">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Adresse complète</label>
                    <input type="text" name="school_address"
                           value="{{ old('school_address', env('SCHOOL_ADDRESS', config('school.address'))) }}"
                           class="form-input" placeholder="Yaoundé, Cameroun">
                </div>
                <div class="mb-4">
                    <label class="form-label">Horaires d'ouverture</label>
                    <input type="text" name="school_hours"
                           value="{{ old('school_hours', env('SCHOOL_HOURS', config('school.hours.label'))) }}"
                           class="form-input" placeholder="Lun–Ven 7h30–17h30">
                </div>
                <div>
                    <label class="form-label">
                        Lien Google Maps
                        <span class="text-gray-400 font-normal">(URL src de l'iframe)</span>
                    </label>
                    <input type="text" name="school_maps_url"
                           value="{{ old('school_maps_url', env('SCHOOL_MAPS_URL', '')) }}"
                           class="form-input"
                           placeholder="https://www.google.com/maps/embed?pb=...">
                    <p class="text-xs text-gray-400 mt-1">
                        Google Maps → Partager → Intégrer une carte → copier l'URL du <code>src</code>
                    </p>
                </div>
            </div>

            {{-- Réseaux sociaux --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4 flex items-center gap-2">
                    📱 Réseaux sociaux & liens
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    @foreach([
                        ['school_facebook',   'Facebook',        env('SCHOOL_FACEBOOK',          config('school.social.facebook')),  'https://facebook.com/...'],
                        ['school_instagram',  'Instagram',       env('SCHOOL_INSTAGRAM',         config('school.social.instagram')), 'https://instagram.com/...'],
                        ['school_twitter',    'Twitter / X',     env('SCHOOL_TWITTER',           config('school.social.twitter')),   'https://twitter.com/...'],
                        ['school_linkedin',   'LinkedIn',        env('SCHOOL_LINKEDIN',          config('school.social.linkedin')),  'https://linkedin.com/...'],
                        ['school_youtube',    'YouTube',         env('SCHOOL_YOUTUBE',           config('school.social.youtube')),   'https://youtube.com/...'],
                        ['espace_parent_url', 'Espace parent',   env('SCHOOL_ESPACE_PARENT_URL', ''),                               'https://...'],
                    ] as [$name, $label, $val, $placeholder])
                    <div>
                        <label class="form-label">{{ $label }}</label>
                        <input type="text" name="{{ $name }}"
                               value="{{ old($name, $val) }}"
                               class="form-input" placeholder="{{ $placeholder }}">
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Statistiques --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4 flex items-center gap-2">
                    📊 Statistiques
                </h3>
                <div class="grid grid-cols-2 gap-4">
                    @foreach([
                        ['stat_eleves',      '🎓 Élèves inscrits',   env('SCHOOL_STAT_ELEVES',      config('school.stats.eleves')),      '2 500+'],
                        ['stat_enseignants', '👩‍🏫 Enseignants',       env('SCHOOL_STAT_ENSEIGNANTS',  config('school.stats.enseignants')), '120+'],
                        ['stat_experience',  "🏛️ Ans d'expérience",  env('SCHOOL_STAT_EXPERIENCE',   config('school.stats.experience')),  '35+'],
                        ['stat_reussite',    '🏆 Taux de réussite',  env('SCHOOL_STAT_REUSSITE',     config('school.stats.reussite')),    '98%'],
                    ] as [$name, $label, $val, $placeholder])
                    <div>
                        <label class="form-label">{{ $label }}</label>
                        <input type="text" name="{{ $name }}"
                               value="{{ old($name, $val) }}"
                               class="form-input" placeholder="{{ $placeholder }}">
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Flash infos --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-1 flex items-center gap-2">
                    📢 Informations flash
                    <span class="text-gray-400 font-normal text-sm">(ticker de la navbar)</span>
                </h3>
                <p class="text-xs text-gray-400 mb-4">
                    Une info par ligne. Elles défilent automatiquement en haut du site.
                </p>
                <textarea name="flash_infos" rows="6" class="form-textarea font-mono text-sm"
                          placeholder="Rentrée 2025–2026 : inscriptions ouvertes&#10;Portes ouvertes le 22 mars...">{{ old('flash_infos', implode("\n", config('school.flash_infos', []))) }}</textarea>
            </div>

        </div>

        {{-- ── Colonne latérale ── --}}
        <div class="space-y-5">

            {{-- Logo --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">🖼️ Logo de l'école</h3>

                @php $logoPath = env('SCHOOL_LOGO', config('school.logo')); @endphp
                @if($logoPath)
                <div class="text-center mb-4 p-3 bg-gray-50 rounded-xl">
                    <img src="{{ Storage::url($logoPath) }}"
                         alt="Logo actuel" class="h-16 mx-auto object-contain">
                    <p class="text-xs text-gray-400 mt-1">Logo actuel</p>
                </div>
                @endif

                <label class="upload-zone block cursor-pointer" for="logo-input">
                    <div id="preview-container" class="hidden mb-3">
                        <img id="logo-preview" src="" alt="Aperçu"
                             class="h-16 mx-auto object-contain">
                    </div>
                    <div id="upload-placeholder">
                        <div class="text-3xl mb-2">🏫</div>
                        <p class="text-sm font-semibold text-gray-600 mb-1">
                            {{ $logoPath ? 'Changer le logo' : 'Ajouter un logo' }}
                        </p>
                        <p class="text-xs text-gray-400">PNG, SVG recommandé</p>
                    </div>
                    <input type="file" id="logo-input" name="school_logo"
                           accept="image/*" class="hidden" onchange="previewLogo(this)">
                </label>
            </div>

            {{-- Config actuelle --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-bold text-gray-700 mb-4">⚙️ Config actuelle</h3>
                <div class="space-y-2 text-sm">
                    @foreach([
                        ['Nom',      env('SCHOOL_NAME',    config('school.name'))],
                        ['Email',    env('SCHOOL_EMAIL',   config('school.email'))],
                        ['Tél',      env('SCHOOL_PHONE',   config('school.phone'))],
                        ['Adresse',  env('SCHOOL_ADDRESS', config('school.address'))],
                        ['Horaires', env('SCHOOL_HOURS',   config('school.hours.label'))],
                        ['Maps',     env('SCHOOL_MAPS_URL') ? '✅ Configurée' : '❌ Non configurée'],
                    ] as [$label, $val])
                    <div class="flex justify-between gap-2 py-1.5 border-b border-gray-50">
                        <span class="text-gray-400 flex-shrink-0">{{ $label }}</span>
                        <span class="font-medium text-gray-700 text-right text-xs truncate max-w-32">
                            {{ $val ?? '—' }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Bouton save --}}
            <button type="submit" class="btn-primary w-full justify-center py-4 text-base">
                💾 Enregistrer tous les paramètres
            </button>

            {{-- Info --}}
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4">
                <p class="text-xs text-blue-600 font-medium mb-1">ℹ️ Comment ça marche ?</p>
                <p class="text-xs text-blue-500 leading-relaxed">
                    Les paramètres sont sauvegardés dans le fichier <code>.env</code>.
                    Les changements sont appliqués immédiatement sur tout le site.
                </p>
            </div>

        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('logo-preview').src = e.target.result;
            document.getElementById('preview-container').classList.remove('hidden');
            document.getElementById('upload-placeholder').classList.add('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush