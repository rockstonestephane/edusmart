@extends('frontend.layout.frontend')

@section('title', config('school.name') . ' — Préinscription')

@section('content')

{{-- HERO --}}
<section class="relative py-16 overflow-hidden"
         @if($hero->imageUrl())
             style="background-image:url('{{ $hero->imageUrl() }}');
                    background-size:cover;background-position:center;"
         @else
             style="background:linear-gradient(135deg,#0d1224 0%,#192686 60%,#0d1224 100%)"
         @endif>

    @if($hero->imageUrl())
    <div class="absolute inset-0"
         style="background:linear-gradient(135deg,rgba(13,18,36,.82) 0%,rgba(25,38,134,.65) 60%,rgba(13,18,36,.7) 100%)">
    </div>
    @endif

    @if(!$hero->imageUrl())
    <div class="blob w-96 h-96 top-0 right-0" style="background:#f5c842"></div>
    <div class="blob w-64 h-64 bottom-0 left-0" style="background:#2952f5"></div>
    @endif

    <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
        <span class="section-badge mb-4"
              style="background:rgba(255,255,255,0.1);color:#f5c842;border-color:rgba(245,200,66,0.3)">
            ✏️ Inscriptions ouvertes
        </span>
        <h1 class="font-display text-5xl md:text-6xl font-bold text-white mt-4 mb-6">
            <span style="background:linear-gradient(135deg,#f5c842,#e8b014);
                         -webkit-background-clip:text;-webkit-text-fill-color:transparent;
                         background-clip:text;">Préinscription</span>
            en ligne
        </h1>
        <p class="text-white/70 text-lg max-w-2xl mx-auto">
            Remplissez ce formulaire pour déposer votre dossier de préinscription.
            Notre équipe vous contactera sous 48h.
        </p>
    </div>
</section>

{{-- DOCUMENTS TÉLÉCHARGEABLES --}}
@if(isset($documents) && $documents->count())
<section class="py-8" style="background:#f7f8fc">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-12" data-aos="fade-up">
            <span class="section-badge">📂 Documents utiles</span>
            <h2 class="font-display text-3xl md:text-4xl font-bold mt-4">
                Téléchargez vos <span class="gradient-text">documents</span>
            </h2>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto">
                Consultez et téléchargez tous les documents nécessaires pour votre inscription.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($documents as $doc)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 card-hover flex flex-col"
                 data-aos="fade-up" data-aos-delay="{{ $loop->index * 80 }}">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 text-2xl"
                     style="background:{{ $doc->couleur }}18">
                    {{ $doc->icone }}
                </div>
                <span class="text-xs font-semibold uppercase tracking-wider mb-2"
                      style="color:{{ $doc->couleur }}">
                    {{ ucfirst($doc->categorie) }}
                </span>
                <h3 class="font-bold text-gray-800 text-base mb-1 flex-1">{{ $doc->nom }}</h3>
                @if($doc->description)
                <p class="text-sm text-gray-500 mb-4">{{ $doc->description }}</p>
                @endif
                <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100">
                    <span class="text-xs text-gray-400">
                        {{ strtoupper($doc->type_fichier) }}
                        @if($doc->taille_formattee) · {{ $doc->taille_formattee }} @endif
                    </span>
                    <a href="{{ $doc->url }}" download
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-bold text-white transition-all hover:-translate-y-0.5"
                       style="background:{{ $doc->couleur }}">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                  d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Télécharger
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
@endif

        {{-- Message succès sous le formulaire --}}
            @if(session('success'))
            <div id="success-message" class="mx-8 mb-8 p-6 rounded-2xl text-center"
                 style="background:#f0fdf4;border:1px solid #bbf7d0">
                <div class="text-4xl mb-3">🎉</div>
                <h3 class="font-display text-xl font-bold text-green-800 mb-2">
                    Préinscription enregistrée !
                </h3>
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
            @endif

{{-- FORMULAIRE --}}
<section class="py-10" style="background:#f7f8fc">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Ancre pour le scroll --}}
        <div id="formulaire"></div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden"
             data-aos="fade-up">

            {{-- Header formulaire --}}
            <div class="p-6 border-b border-gray-100"
                 style="background:linear-gradient(135deg,#f0f4ff,#dce6ff)">
                <h2 class="font-display text-xl font-bold text-gray-800">
                    Dossier de préinscription — {{ date('Y') }}/{{ date('Y') + 1 }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Tous les champs marqués <span class="text-red-500">*</span> sont obligatoires.
                </p>
            </div>

            <form method="POST" action="{{ lroute('preinscription.store') }}"
                  enctype="multipart/form-data"
                  class="p-8 space-y-8">
                @csrf

                {{-- Section 1 : Élève --}}
                <div>
                    <h3 class="font-display text-lg font-bold text-gray-800 mb-4 pb-2
                               border-b border-gray-100 flex items-center gap-2">
                        🎓 Informations de l'élève ou de l'étudiant.
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nom <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nom" value="{{ old('nom') }}"
                                   placeholder="Nom de famille"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                          outline-none transition-all focus:border-blue-500
                                          focus:ring-2 focus:ring-blue-100
                                          @error('nom') border-red-400 @enderror"
                                   required>
                            @error('nom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Prénom <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="prenom" value="{{ old('prenom') }}"
                                   placeholder="Prénom"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                          outline-none transition-all focus:border-blue-500
                                          focus:ring-2 focus:ring-blue-100
                                          @error('prenom') border-red-400 @enderror"
                                   required>
                            @error('prenom') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Date de naissance <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="date_naissance"
                                   value="{{ old('date_naissance') }}"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                          outline-none transition-all focus:border-blue-500
                                          focus:ring-2 focus:ring-blue-100"
                                   required>
                            @error('date_naissance') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Sexe <span class="text-red-500">*</span>
                            </label>
                            <select name="sexe"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                           outline-none transition-all focus:border-blue-500
                                           focus:ring-2 focus:ring-blue-100 bg-white"
                                    required>
                                <option value="">-- Choisir --</option>
                                <option value="masculin"  {{ old('sexe') == 'masculin'  ? 'selected' : '' }}>Masculin</option>
                                <option value="feminin"   {{ old('sexe') == 'feminin'   ? 'selected' : '' }}>Féminin</option>
                            </select>
                            @error('sexe') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Classe demandée <span class="text-red-500">*</span>
                            </label>
                            <select name="classe_demandee"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                           outline-none transition-all focus:border-blue-500
                                           focus:ring-2 focus:ring-blue-100 bg-white"
                                    required>
                                <option value="">-- Choisir --</option>
                                <optgroup label="Primaire">
                                    @foreach(['CP','CE1','CE2','CM1','CM2'] as $classe)
                                    <option value="{{ $classe }}" {{ old('classe_demandee') == $classe ? 'selected' : '' }}>{{ $classe }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Collège">
                                    @foreach(['6ème','5ème','4ème','3ème'] as $classe)
                                    <option value="{{ $classe }}" {{ old('classe_demandee') == $classe ? 'selected' : '' }}>{{ $classe }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Lycée">
                                    @foreach(['Seconde','Première','Terminale'] as $classe)
                                    <option value="{{ $classe }}" {{ old('classe_demandee') == $classe ? 'selected' : '' }}>{{ $classe }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Classes Préparatoires">
                                    @foreach(['CPGE 1ère année','CPGE 2ème année'] as $classe)
                                    <option value="{{ $classe }}" {{ old('classe_demandee') == $classe ? 'selected' : '' }}>{{ $classe }}</option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="Enseignement Supérieur">
                                    @foreach([
                                        'Licence 1','Licence 2','Licence 3',
                                        'Master 1','Master 2',
                                        'BTS 1ère année','BTS 2ème année',
                                        'DUT 1ère année','DUT 2ème année',
                                        'Doctorat'
                                    ] as $classe)
                                    <option value="{{ $classe }}" {{ old('classe_demandee') == $classe ? 'selected' : '' }}>{{ $classe }}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                            @error('classe_demandee') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Année scolaire <span class="text-red-500">*</span>
                            </label>
                            <select name="annee_scolaire"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                           outline-none transition-all focus:border-blue-500
                                           focus:ring-2 focus:ring-blue-100 bg-white"
                                    required>
                                <option value="">-- Choisir --</option>
                                @php $startYear = date('Y'); @endphp
                                @for($y = $startYear; $y <= 2039; $y++)
                                    @php $annee = $y . '/' . ($y + 1); @endphp
                                    <option value="{{ $annee }}" {{ old('annee_scolaire') == $annee ? 'selected' : '' }}>
                                        {{ $annee }}
                                    </option>
                                @endfor
                            </select>
                            @error('annee_scolaire') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Acte de naissance --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Acte de naissance
                                <span class="text-gray-400 font-normal">(PDF, JPG, PNG — max 5 Mo)</span>
                            </label>
                            <label class="flex items-center gap-3 w-full px-4 py-3 border border-gray-200
                                          rounded-xl text-sm cursor-pointer transition-all
                                          hover:border-blue-400 hover:bg-blue-50
                                          @error('acte_naissance') border-red-400 @enderror">
                                <span class="text-xl">📄</span>
                                <span id="acte-label" class="text-gray-400 truncate">
                                    Choisir un fichier…
                                </span>
                                <input type="file" name="acte_naissance" id="acte_naissance"
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       class="hidden"
                                       onchange="updateLabel(this, 'acte-label')">
                            </label>
                            @error('acte_naissance') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- Bulletin --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Bulletin ou relevé de notes
                                <span class="text-gray-400 font-normal">(année précédente — PDF, JPG, PNG — max 5 Mo)</span>
                            </label>
                            <label class="flex items-center gap-3 w-full px-4 py-3 border border-gray-200
                                          rounded-xl text-sm cursor-pointer transition-all
                                          hover:border-blue-400 hover:bg-blue-50
                                          @error('bulletin') border-red-400 @enderror">
                                <span class="text-xl">📋</span>
                                <span id="bulletin-label" class="text-gray-400 truncate">
                                    Choisir un fichier…
                                </span>
                                <input type="file" name="bulletin" id="bulletin"
                                       accept=".pdf,.jpg,.jpeg,.png"
                                       class="hidden"
                                       onchange="updateLabel(this, 'bulletin-label')">
                            </label>
                            @error('bulletin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                    </div>
                </div>

                {{-- Section 2 : Parent --}}
                <div>
                    <h3 class="font-display text-lg font-bold text-gray-800 mb-4 pb-2
                               border-b border-gray-100 flex items-center gap-2">
                        👨‍👩‍👧 Informations du parent / tuteur
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Nom du parent <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nom_parent" value="{{ old('nom_parent') }}"
                                   placeholder="Nom complet du parent"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                          outline-none transition-all focus:border-blue-500
                                          focus:ring-2 focus:ring-blue-100"
                                   required>
                            @error('nom_parent') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Téléphone <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" name="telephone_parent"
                                   value="{{ old('telephone_parent') }}"
                                   placeholder="+237 6XX XXX XXX"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                          outline-none transition-all focus:border-blue-500
                                          focus:ring-2 focus:ring-blue-100"
                                   required>
                            @error('telephone_parent') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email_parent"
                                   value="{{ old('email_parent') }}"
                                   placeholder="parent@email.com"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                          outline-none transition-all focus:border-blue-500
                                          focus:ring-2 focus:ring-blue-100"
                                   required>
                            @error('email_parent') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Adresse
                            </label>
                            <input type="text" name="adresse" value="{{ old('adresse') }}"
                                   placeholder="Quartier, ville..."
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                          outline-none transition-all focus:border-blue-500
                                          focus:ring-2 focus:ring-blue-100">
                        </div>

                    </div>
                </div>

                {{-- Section 3 : Message --}}
                <div>
                    <h3 class="font-display text-lg font-bold text-gray-800 mb-4 pb-2
                               border-b border-gray-100 flex items-center gap-2">
                        💬 Message (optionnel)
                    </h3>
                    <textarea name="message" rows="4"
                              placeholder="Questions, informations complémentaires..."
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                     outline-none transition-all focus:border-blue-500
                                     focus:ring-2 focus:ring-blue-100 resize-vertical">{{ old('message') }}</textarea>
                </div>

                {{-- Submit --}}
                <div class="pt-4 border-t border-gray-100">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-10 py-4 rounded-xl
                                   font-bold text-sm text-white hover:-translate-y-1
                                   transition-all duration-300 w-full justify-center"
                            style="background:linear-gradient(135deg,#2952f5,#152dd4);
                                   box-shadow:0 8px 24px rgba(41,82,245,0.3)">
                        ✏️ Soumettre ma préinscription
                    </button>
                    <p class="text-xs text-gray-400 text-center mt-3">
                        En soumettant ce formulaire, vous acceptez d'être contacté par notre établissement.
                    </p>
                </div>

            </form>

           

        </div>
    </div>
</section>

{{-- Scroll + disparition automatique --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const msg = document.getElementById('success-message');
        if (msg) {
            msg.scrollIntoView({ behavior: 'smooth', block: 'center' });

            setTimeout(function () {
                msg.style.transition = 'opacity 0.8s ease';
                msg.style.opacity = '0';
                setTimeout(function () { msg.remove(); }, 800);
            }, 5000);
        }
    });
</script>
@endif

@push('scripts')
<script>
function updateLabel(input, labelId) {
    const label = document.getElementById(labelId);
    if (input.files && input.files[0]) {
        label.textContent = input.files[0].name;
        label.classList.remove('text-gray-400');
        label.classList.add('text-blue-600', 'font-medium');
    } else {
        label.textContent = 'Choisir un fichier…';
        label.classList.add('text-gray-400');
        label.classList.remove('text-blue-600', 'font-medium');
    }
}
</script>
@endpush

@endsection