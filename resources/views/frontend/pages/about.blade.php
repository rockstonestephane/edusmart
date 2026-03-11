@extends('frontend.layout.frontend')

@section('title', config('school.name') . ' — ' . __('about.hero_title'))

@section('content')

{{-- ════════════ 1. HERO ════════════ --}}
@php
    $heroBg = $about->hero_image
        ? 'background-image:url(' . image_url($about->hero_image) . ');background-size:cover;background-position:center;'
        : 'background:linear-gradient(135deg,#0d1224 0%,#192686 60%,#0d1224 100%)';
@endphp
<section class="relative py-32 overflow-hidden" style="{{ $heroBg }}">

    @if($about->hero_image)
    <div class="absolute inset-0" style="background:rgba(13,18,36,0.72)"></div>
    @endif

    <div class="blob w-96 h-96 top-0 right-0" style="background:#f5c842"></div>
    <div class="blob w-64 h-64 bottom-0 left-0" style="background:#2952f5"></div>

    <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
        <span class="section-badge mb-4"
              style="background:rgba(255,255,255,0.1);color:#f5c842;border-color:rgba(245,200,66,0.3)">
            {{ __('about.hero_badge') }}
        </span>
        <h1 class="font-display text-5xl md:text-6xl font-bold text-white mt-4 mb-6">
            {{ __('about.hero_title') }} <br>
            <span style="background:linear-gradient(135deg,#f5c842,#e8b014);
                         -webkit-background-clip:text;-webkit-text-fill-color:transparent;
                         background-clip:text;">
                {{ config('school.name') }}
            </span>
        </h1>
        <p class="text-white/70 text-lg max-w-2xl mx-auto">
            {{ config('school.description') }}
        </p>
    </div>
</section>


{{-- ════════════ 2. HISTOIRE ════════════ --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

            <div data-aos="fade-right">
                <span class="section-badge">{{ __('about.histoire_badge') }}</span>
                <h2 class="font-display text-4xl font-bold mt-4 mb-6">
                    {!! str_replace(':year', '<span class="gradient-text">' . config('school.founded', '1989') . '</span>', __('about.histoire_title')) !!}
                </h2>

                <p class="text-gray-600 leading-relaxed mb-4">
                    {{ $about->histoire_p1 ?? __('about.histoire_p1_default', ['year' => config('school.founded', '1989'), 'name' => config('school.name')]) }}
                </p>
                <p class="text-gray-600 leading-relaxed mb-4">
                    {{ $about->histoire_p2 ?? __('about.histoire_p2_default') }}
                </p>
                <p class="text-gray-600 leading-relaxed">
                    {{ $about->histoire_p3 ?? __('about.histoire_p3_default', ['eleves' => config('school.stats.eleves', '2 500')]) }}
                </p>
            </div>

            <div data-aos="fade-left">
                <div class="grid grid-cols-2 gap-4">
                    @if($statistiques->count())
                        @foreach($statistiques as $stat)
                        <div class="card-hover bg-white rounded-2xl p-6 shadow-md border border-gray-100 text-center">
                            @if($stat->icone)
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700
                                        flex items-center justify-center text-2xl mx-auto mb-3 shadow-lg">
                                {{ $stat->icone }}
                            </div>
                            @endif
                            <div class="font-display text-3xl font-bold mb-1" style="color:#2952f5">
                                {{ $stat->valeur }}{{ $stat->suffixe }}
                            </div>
                            <div class="text-sm text-gray-500">{{ $stat->label }}</div>
                        </div>
                        @endforeach
                    @else
                        @foreach([
                            ['🎓', config('school.stats.eleves', '2 500+'),     __('about.stat_eleves'),      'from-blue-500 to-blue-700'],
                            ['👩‍🏫', config('school.stats.enseignants', '120+'), __('about.stat_enseignants'), 'from-purple-500 to-purple-700'],
                            ['🏛️', config('school.stats.experience', '35+'),    __('about.stat_experience'),  'from-emerald-500 to-emerald-700'],
                            ['🏆', config('school.stats.reussite', '98%'),      __('about.stat_reussite'),    'from-orange-500 to-red-500'],
                        ] as [$icon, $num, $label, $grad])
                        <div class="card-hover bg-white rounded-2xl p-6 shadow-md border border-gray-100 text-center">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $grad }}
                                        flex items-center justify-center text-2xl mx-auto mb-3 shadow-lg">
                                {{ $icon }}
                            </div>
                            <div class="font-display text-3xl font-bold mb-1" style="color:#2952f5">{{ $num }}</div>
                            <div class="text-sm text-gray-500">{{ $label }}</div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

        </div>
    </div>
</section>


{{-- ════════════ 3. MOT DU DIRECTEUR ════════════ --}}
<section class="py-24" style="background:#f7f8fc">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-16" data-aos="fade-up">
            <span class="section-badge">{{ __('about.directeur_badge') }}</span>
            <h2 class="font-display text-4xl font-bold mt-4">
                {{ __('about.directeur_title') }} <span class="gradient-text">{{ __('about.directeur_title_accent') }}</span>
            </h2>
        </div>

        @if($motDirecteur)
        <div class="bg-white rounded-3xl shadow-md border border-gray-100 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">

                <div class="p-10 lg:p-14 flex flex-col justify-between min-h-96" data-aos="fade-right">
                    <div>
                        <div class="text-8xl leading-none font-serif mb-2"
                             style="color:#2952f5;opacity:0.15;line-height:1">"</div>
                        <p class="text-gray-600 leading-relaxed text-base lg:text-lg -mt-6">
                            {{ $motDirecteur->texte }}
                        </p>
                    </div>
                    <div class="mt-10">
                        <div class="w-16 h-1 rounded-full mb-6"
                             style="background:linear-gradient(135deg,#f5c842,#e8b014)"></div>
                        <div class="flex items-center gap-4">
                            @if($motDirecteur->photo)
                            <img src="{{ image_url($motDirecteur->photo) }}"
                                 alt="{{ $motDirecteur->nom }}"
                                 class="w-14 h-14 rounded-full object-cover shadow-md
                                        border-4 border-white ring-2 ring-blue-100 flex-shrink-0">
                            @else
                            <div class="w-14 h-14 rounded-full flex items-center justify-center
                                        text-xl font-bold text-white shadow-md flex-shrink-0"
                                 style="background:linear-gradient(135deg,#2952f5,#152dd4)">
                                {{ mb_substr($motDirecteur->nom, 0, 1) }}
                            </div>
                            @endif
                            <div>
                                <div class="font-display font-bold text-gray-800 uppercase tracking-wide text-sm">
                                    {{ $motDirecteur->nom }}
                                </div>
                                <div class="text-sm font-semibold uppercase tracking-widest mt-0.5"
                                     style="color:#2952f5;font-size:0.7rem">
                                    {{ $motDirecteur->poste }}
                                </div>
                            </div>
                            @if($motDirecteur->signature)
                            <img src="{{ image_url($motDirecteur->signature) }}"
                                 alt="Signature"
                                 class="h-10 object-contain ml-auto opacity-80">
                            @endif
                        </div>
                    </div>
                </div>

                <div class="relative min-h-72 lg:min-h-0" data-aos="fade-left">
                    @if($motDirecteur->photo)
                    <img src="{{ Storage::url($motDirecteur->photo) }}"
                         alt="{{ $motDirecteur->nom }}"
                         class="w-full h-full object-cover object-top">
                    <div class="absolute bottom-6 left-6 bg-white rounded-2xl px-5 py-3 shadow-lg
                                flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl"
                             style="background:linear-gradient(135deg,#f5c842,#e8b014)">🏛️</div>
                        <div>
                            <div class="text-xs text-gray-400">{{ __('about.directeur_etablissement') }}</div>
                            <div class="text-sm font-bold text-gray-800">{{ config('school.name') }}</div>
                        </div>
                    </div>
                    @else
                    <div class="w-full h-full flex items-center justify-center min-h-72"
                         style="background:linear-gradient(135deg,#0d1224 0%,#192686 60%,#0d1224 100%)">
                        <div class="text-center">
                            <div class="w-32 h-32 rounded-full flex items-center justify-center
                                        text-5xl font-bold text-white mx-auto mb-4 shadow-2xl"
                                 style="background:rgba(255,255,255,0.1);border:3px solid rgba(245,200,66,0.5)">
                                {{ mb_substr($motDirecteur->nom, 0, 1) }}
                            </div>
                            <div class="text-white font-bold text-lg">{{ $motDirecteur->nom }}</div>
                            <div class="text-sm mt-1" style="color:#f5c842">{{ $motDirecteur->poste }}</div>
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>

        @else
        {{-- Fallback --}}
        <div class="bg-white rounded-3xl shadow-md border border-gray-100 overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <div class="p-10 lg:p-14 flex flex-col justify-center">
                    <div class="text-8xl leading-none font-serif mb-4"
                         style="color:#2952f5;opacity:0.15">"</div>
                    <p class="text-gray-600 leading-relaxed text-base lg:text-lg -mt-8">
                        {{ __('about.directeur_fallback_texte', ['name' => config('school.name')]) }}
                    </p>
                    <div class="my-6 w-16 h-1 rounded-full"
                         style="background:linear-gradient(135deg,#f5c842,#e8b014)"></div>
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-full flex items-center justify-center
                                    text-xl font-bold text-white shadow-md flex-shrink-0"
                             style="background:linear-gradient(135deg,#2952f5,#152dd4)">D</div>
                        <div>
                            <div class="font-display font-bold text-gray-800">{{ __('about.directeur_fallback_nom') }}</div>
                            <div class="text-sm font-semibold" style="color:#2952f5">{{ __('about.directeur_fallback_poste') }}</div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center min-h-72"
                     style="background:linear-gradient(135deg,#0d1224 0%,#192686 60%,#0d1224 100%)">
                    <div class="text-center">
                        <div class="w-32 h-32 rounded-full flex items-center justify-center
                                    text-5xl font-bold text-white mx-auto mb-4 shadow-2xl"
                             style="background:rgba(255,255,255,0.1);border:3px solid rgba(245,200,66,0.5)">
                            🏛️
                        </div>
                        <div class="text-white font-bold">{{ config('school.name') }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</section>


{{-- ════════════ 4. VALEURS ════════════ --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="section-badge">{{ __('about.valeurs_badge') }}</span>
            <h2 class="font-display text-4xl font-bold mt-4">
                {{ __('about.valeurs_title') }} <span class="gradient-text">{{ __('about.valeurs_title_accent') }}</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @if($valeurs->count())
                @foreach($valeurs as $i => $valeur)
                <div class="card-hover bg-white rounded-2xl p-6 shadow-sm border border-gray-100"
                     data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br {{ $valeur->couleur ?? 'from-blue-500 to-blue-700' }}
                                flex items-center justify-center text-xl mb-4 shadow-md">
                        {{ $valeur->icone ?? '💡' }}
                    </div>
                    <h3 class="font-display text-lg font-bold mb-2">{{ $valeur->titre }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $valeur->description }}</p>
                </div>
                @endforeach
            @else
                @foreach([
                    ['🎯', __('about.valeur_excellence_titre'),    __('about.valeur_excellence_desc'),    'from-blue-500 to-blue-700'],
                    ['🤝', __('about.valeur_bienveillance_titre'), __('about.valeur_bienveillance_desc'), 'from-emerald-500 to-emerald-700'],
                    ['🌍', __('about.valeur_ouverture_titre'),     __('about.valeur_ouverture_desc'),     'from-purple-500 to-purple-700'],
                    ['⚡', __('about.valeur_innovation_titre'),    __('about.valeur_innovation_desc'),    'from-orange-500 to-red-500'],
                    ['🏆', __('about.valeur_discipline_titre'),    __('about.valeur_discipline_desc'),    'from-sky-500 to-indigo-600'],
                    ['❤️', __('about.valeur_humanisme_titre'),     __('about.valeur_humanisme_desc'),     'from-pink-500 to-rose-600'],
                ] as $i => [$icon, $titre, $desc, $grad])
                <div class="card-hover bg-white rounded-2xl p-6 shadow-sm border border-gray-100"
                     data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br {{ $grad }}
                                flex items-center justify-center text-xl mb-4 shadow-md">
                        {{ $icon }}
                    </div>
                    <h3 class="font-display text-lg font-bold mb-2">{{ $titre }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $desc }}</p>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>


{{-- ════════════ 5. ÉQUIPE ════════════ --}}
<section class="py-24" style="background:#f7f8fc">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="section-badge">{{ __('about.equipe_badge') }}</span>
            <h2 class="font-display text-4xl font-bold mt-4">
                {{ __('about.equipe_title') }} <span class="gradient-text">{{ __('about.equipe_title_accent') }}</span>
            </h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @if($equipe->count())
                @foreach($equipe as $i => $membre)
                <div class="equipe-card bg-white rounded-2xl p-8 shadow-md border-2 border-transparent text-center"
                     data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                    @if($membre->photo)
                    <img src="{{ image_url($membre->photo) }}"
                         alt="{{ $membre->nom }}"
                         class="equipe-photo w-20 h-20 rounded-full object-cover mx-auto mb-4 shadow-lg
                                border-4 border-white ring-2 ring-blue-100">
                    @else
                    <div class="w-20 h-20 rounded-full flex items-center justify-center text-3xl
                                font-bold text-white mx-auto mb-4 shadow-lg"
                         style="background:linear-gradient(135deg,#2952f5,#152dd4)">
                        {{ mb_substr($membre->nom, 0, 1) }}
                    </div>
                    @endif
                    <h3 class="font-display text-lg font-bold mb-1">{{ $membre->nom }}</h3>
                    <p class="text-sm font-semibold mb-3" style="color:#2952f5">{{ $membre->poste }}</p>
                    @if($membre->bio)
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $membre->bio }}</p>
                    @endif
                </div>
                @endforeach
            @else
                @foreach([
                    ['👨‍💼', 'Dr. Jean MBARGA',  __('about.equipe_mbarga_poste'),  __('about.equipe_mbarga_bio')],
                    ['👩‍🏫', 'Mme Claire FOUDA', __('about.equipe_fouda_poste'),   __('about.equipe_fouda_bio')],
                    ['👨‍💻', 'M. Paul NGASSA',   __('about.equipe_ngassa_poste'),  __('about.equipe_ngassa_bio')],
                ] as $i => [$icon, $nom, $poste, $bio])
                <div class="equipe-card bg-white rounded-2xl p-8 shadow-md border-2 border-transparent text-center"
                     data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                    <div class="w-20 h-20 rounded-full flex items-center justify-center text-4xl mx-auto mb-4
                                shadow-lg" style="background:linear-gradient(135deg,#f0f4ff,#dce6ff)">
                        {{ $icon }}
                    </div>
                    <h3 class="font-display text-lg font-bold mb-1">{{ $nom }}</h3>
                    <p class="text-sm font-semibold mb-3" style="color:#2952f5">{{ $poste }}</p>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $bio }}</p>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<style>
.equipe-card { transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease; cursor: default; }
.equipe-card:hover { transform: scale(1.03); border-color: #facc15; box-shadow: 0 12px 32px rgba(250,204,21,0.25); }
.equipe-photo { transition: transform 0.3s ease, border-color 0.3s ease; }
.equipe-card:hover .equipe-photo { transform: scale(1.10); border-color: #facc15; }
</style>


{{-- ════════════ 6. CONTACT RAPIDE ════════════ --}}
<section class="py-20 relative overflow-hidden"
         style="background:linear-gradient(135deg,#152dd4 0%,#1a3de8 50%,#0d1224 100%)">
    <div class="max-w-4xl mx-auto px-4 text-center relative z-10" data-aos="zoom-in">
        <h2 class="font-display text-4xl font-bold text-white mb-4">
            {{ __('about.contact_title') }}
            <span style="background:linear-gradient(135deg,#f5c842,#e8b014);
                         -webkit-background-clip:text;-webkit-text-fill-color:transparent;
                         background-clip:text;">{{ __('about.contact_title_accent') }}</span>
        </h2>
        <p class="text-white/70 mb-4">{{ config('school.address') }}</p>
        <p class="text-white/70 mb-8">{{ config('school.hours.detail') }}</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ lroute('contact') }}"
               class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-bold text-sm
                      text-dark hover:-translate-y-1 transition-all"
               style="background:linear-gradient(135deg,#f5c842,#e8b014)">
                {{ __('about.contact_btn') }}
            </a>
            <a href="{{ lroute('preinscription') }}"
               class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-semibold text-sm
                      text-white border border-white/25 hover:bg-white/10 hover:-translate-y-1 transition-all">
                {{ __('about.preinscription_btn') }}
            </a>
        </div>
    </div>
</section>

@endsection