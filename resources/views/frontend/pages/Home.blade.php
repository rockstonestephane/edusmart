{{--
╔══════════════════════════════════════════════════════════════════════╗
║  EDU SMART SCHOOL V2 — Page d'accueil                               ║
║  resources/views/frontend/pages/home.blade.php                      ║
║                                                                      ║
║  Contrôleur : App\Http\Controllers\Frontend\HomeController           ║
║  Route      : Route::get('/', [HomeController::class,'index'])       ║
║               ->name('home');                                        ║
║                                                                      ║
║  Variables attendues depuis le contrôleur :                          ║
║    $actualites   → Collection de modèles Actualite (3 dernières)     ║
║    $formations   → Collection de modèles Formation (6 max)           ║
║    $temoignages  → Collection de modèles Temoignage                  ║
║    $galerie      → Collection de modèles Galerie (6 photos)          ║
║    $heroSlides   → Collection de modèles HeroSlide                   ║
║    $statistiques → Collection de modèles Statistique (dynamique DB)  ║
║    $rentree      → Modèle RentreeScolaire actif (dynamique DB)       ║
╚══════════════════════════════════════════════════════════════════════╝
--}}

@extends('frontend.layout.frontend')

@section('title', config('school.name', 'EduSmart School') . ' — Accueil')

@push('styles')
<style>
    /* ── Hero ──────────────────────────────────────────── */
    .hero-swiper            { width:100%; height:100svh; min-height:580px; }
    .hero-swiper .swiper-slide { position:relative; display:flex; align-items:center; justify-content:center; }
    .slide-bg               { position:absolute; inset:0; background-size:cover; background-position:center; transform:scale(1.06); transition:transform 6s ease; }
    .swiper-slide-active .slide-bg { transform:scale(1); }
    .hero-overlay           { position:absolute; inset:0; background:linear-gradient(135deg,rgba(13,18,36,.78) 0%,rgba(25,38,134,.55) 60%,transparent 100%); }
    .hero-content           { position:relative; z-index:2; padding-left:1rem; padding-right:1rem; }
    .swiper-pagination-bullet        { background:rgba(255,255,255,.5)!important; opacity:1!important; width:8px!important; height:8px!important; }
    .swiper-pagination-bullet-active { background:#f5c842!important; width:28px!important; border-radius:4px!important; }
    .swiper-button-next,
    .swiper-button-prev     { color:#fff!important; background:rgba(255,255,255,.12); width:50px!important; height:50px!important; border-radius:50%; backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,.2); transition:background .3s; }
    .swiper-button-next:hover,
    .swiper-button-prev:hover { background:rgba(41,82,245,.6)!important; }
    .swiper-button-next::after,
    .swiper-button-prev::after { font-size:16px!important; font-weight:700; }

    /* ── Hero responsive mobile ────────────────────────── */
    @media (max-width: 639px) {
        .swiper-button-next,
        .swiper-button-prev { display:none!important; }
        .swiper-pagination  { bottom:16px!important; }
    }

    /* ── Hero responsive tablette ──────────────────────── */
    @media (min-width: 640px) and (max-width: 1023px) {
        .swiper-button-next,
        .swiper-button-prev { width:40px!important; height:40px!important; }
        .swiper-button-next::after,
        .swiper-button-prev::after { font-size:13px!important; }
    }

    /* ── Compteur animé ────────────────────────────────── */
    .stat-counter { display:inline-block; }

    /* ── Utilitaires section ───────────────────────────── */
    .section-badge  { display:inline-flex; align-items:center; gap:8px; background:linear-gradient(135deg,#f0f4ff,#dce6ff); color:#1a3de8; font-size:.75rem; font-weight:600; letter-spacing:.12em; text-transform:uppercase; padding:6px 16px; border-radius:100px; border:1px solid rgba(41,82,245,.15); }
    .gradient-text  { background:linear-gradient(135deg,#2952f5,#e8b014); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
    .card-hover     { transition:transform .35s cubic-bezier(.22,.68,0,1.2),box-shadow .35s ease; }
    .card-hover:hover { transform:translateY(-8px); box-shadow:0 24px 48px rgba(41,82,245,.14); }
    .blob           { position:absolute; border-radius:60% 40% 70% 30%/50% 60% 40% 50%; filter:blur(56px); opacity:.18; pointer-events:none; }

    /* ── Gallery swiper slides ─────────────────────────── */
    .gallery-swiper .swiper-slide { width:288px; }

    /* ── Line clamp ────────────────────────────────────── */
    .line-clamp-2 { overflow:hidden; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; }
    .line-clamp-3 { overflow:hidden; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; }
</style>
@endpush

@section('content')

{{-- ════════════════════════════════════════════════════ --}}
{{-- 1. HERO SLIDER                                      --}}
{{-- ════════════════════════════════════════════════════ --}}
<section class="hero-swiper swiper" id="hero" aria-label="Diaporama principal">
    <div class="swiper-wrapper">

        {{-- Slides dynamiques (depuis DB) ou fallback statique --}}
        @if(isset($heroSlides) && $heroSlides->count())

            @foreach($heroSlides as $slide)
            <div class="swiper-slide">
                <div class="slide-bg" style="background-image:url('{{ Storage::url($slide->image) }}')"></div>
                <div class="hero-overlay"></div>
                <div class="hero-content text-center text-white px-4 max-w-4xl mx-auto">
                    <p class="inline-block mb-5 text-sm font-semibold tracking-[0.25em] uppercase
                               border border-white/30 rounded-full px-5 py-1.5"
                       style="color:#f5c842"
                       data-aos="fade-down" data-aos-delay="100">
                        {{ $slide->surtitre ?? config('school.name', 'EduSmart School') }}
                    </p>
                    <h1 class="font-display text-3xl sm:text-5xl md:text-6xl lg:text-7xl font-bold leading-snug mb-4 md:mb-6"
                            data-aos="fade-up" data-aos-delay="200">
                        {!! $slide->titre !!}
                    </h1>
                    <p class="text-base md:text-xl text-white/80 mb-6 md:mb-10 max-w-2xl mx-auto px-2"
                        data-aos="fade-up" data-aos-delay="350">
                        {{ $slide->description }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center"
                         data-aos="fade-up" data-aos-delay="450">
                        @if($slide->btn1_label)
                        <a href="{{ $slide->btn1_url ?? lroute('preinscription') }}"
                           class="inline-flex items-center gap-2.5 px-8 py-4 rounded-xl font-semibold text-sm
                                  bg-gradient-to-r from-primary-500 to-primary-700 text-white
                                  shadow-2xl shadow-primary-600/40 hover:-translate-y-1 transition-all duration-300">
                            {{ $slide->btn1_label }}
                        </a>
                        @endif
                        @if($slide->btn2_label)
                        <a href="{{ $slide->btn2_url ?? lroute('about') }}"
                           class="inline-flex items-center gap-2.5 px-8 py-4 rounded-xl font-semibold text-sm
                                  bg-white/10 text-white border border-white/30 backdrop-blur-sm
                                  hover:bg-white/20 hover:-translate-y-1 transition-all duration-300">
                            {{ $slide->btn2_label }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach

        @else
        {{-- ── Fallback statique (développement / pas de slides en DB) ── --}}
        @foreach([
            [
                'surtitre' => 'Bienvenue à ' . config('school.name','EduSmart School'),
                'titre'    => "L'excellence académique<br><span class=\"gradient-text\">à votre portée</span>",
                'desc'     => "Un environnement d'apprentissage inspirant, des enseignants passionnés et un programme reconnu à l'international.",
                'bg'       => 'images/hero/slide-1.jpg',
                'btn1'     => ['Préinscription 2025–2026', null],
                'btn2'     => ["Découvrir l'établissement", null],
            ],
            [
                'surtitre' => 'Nos formations',
                'titre'    => "Des programmes<br><span class=\"gradient-text\">d'avenir</span>",
                'desc'     => "Du primaire au supérieur, découvrez des filières adaptées aux défis du monde contemporain.",
                'bg'       => 'images/hero/slide-2.jpg',
                'btn1'     => ['Voir les formations', null],
                'btn2'     => null,
            ],
            [
                'surtitre' => 'Vie scolaire',
                'titre'    => "Un campus<br><span class=\"gradient-text\">vibrant &amp; inclusif</span>",
                'desc'     => "Sport, culture, clubs étudiants : l'épanouissement au cœur de nos priorités.",
                'bg'       => 'images/hero/slide-3.jpg',
                'btn1'     => ['Voir la galerie', null],
                'btn2'     => null,
            ],
        ] as $slide)
        <div class="swiper-slide">
            <div class="slide-bg" style="background-image:url('{{ asset($slide['bg']) }}')"></div>
            <div class="hero-overlay"></div>
            <div class="hero-content text-center text-white px-4 max-w-4xl mx-auto">
                <p class="inline-block mb-5 text-sm font-semibold tracking-[0.25em] uppercase
                           border rounded-full px-5 py-1.5"
                   style="color:#f5c842;border-color:rgba(245,200,66,.4)"
                   data-aos="fade-down" data-aos-delay="100">
                    {{ $slide['surtitre'] }}
                </p>
                <h1 class="font-display text-5xl md:text-7xl font-bold leading-tight mb-6"
                    data-aos="fade-up" data-aos-delay="200">
                    {!! $slide['titre'] !!}
                </h1>
                <p class="text-lg md:text-xl text-white/80 mb-10 max-w-2xl mx-auto"
                   data-aos="fade-up" data-aos-delay="350">
                    {{ $slide['desc'] }}
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center"
                     data-aos="fade-up" data-aos-delay="450">
                    @if($slide['btn1'])
                    <a href="{{ $slide['btn1'][1] ?? lroute('preinscription') }}"
                       class="inline-flex items-center gap-2.5 px-8 py-4 rounded-xl font-semibold text-sm
                              bg-gradient-to-r from-primary-500 to-primary-700 text-white
                              shadow-2xl shadow-primary-600/40 hover:-translate-y-1 transition-all duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        {{ $slide['btn1'][0] }}
                    </a>
                    @endif
                    @if($slide['btn2'])
                    <a href="{{ $slide['btn2'][1] ?? lroute('about') }}"
                       class="inline-flex items-center gap-2.5 px-8 py-4 rounded-xl font-semibold text-sm
                              bg-white/10 text-white border border-white/30 backdrop-blur-sm
                              hover:bg-white/20 hover:-translate-y-1 transition-all duration-300">
                        {{ $slide['btn2'][0] }}
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
        @endif

    </div>{{-- /swiper-wrapper --}}

    <div class="swiper-pagination" style="bottom:28px"></div>
    <div class="swiper-button-prev" style="left:24px"></div>
    <div class="swiper-button-next" style="right:24px"></div>

    {{-- Indicateur scroll --}}
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-10 hidden md:block" aria-hidden="true">
        <div class="w-6 h-10 border-2 border-white/40 rounded-full flex justify-center pt-2 animate-bounce">
            <div class="w-1 h-2.5 bg-white/60 rounded-full"></div>
        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════ --}}
{{-- 2. STATISTIQUES — DYNAMIQUES DEPUIS LA DB           --}}
{{-- ════════════════════════════════════════════════════ --}}
<section class="py-16 relative overflow-hidden stats-section"
         style="background:linear-gradient(90deg,#152dd4 0%,#1a3de8 50%,#152dd4 100%)"
         aria-label="Chiffres clés">
    <div class="blob w-96 h-96 top-0 right-0" style="background:#f5c842"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">

            @if(isset($statistiques) && $statistiques->count())
                {{-- ── Statistiques dynamiques depuis la DB ── --}}
                @foreach($statistiques as $i => $stat)
                <div class="text-center text-white"
                     data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                    @if($stat->icone)
                    <div class="text-4xl mb-2" aria-hidden="true">{{ $stat->icone }}</div>
                    @endif
                    <div class="font-display text-4xl md:text-5xl font-bold" style="color:#f5c842">
                        <span class="stat-counter" data-target="{{ $stat->valeur }}">{{ $stat->valeur }}</span>{{ $stat->suffixe }}
                    </div>
                    <div class="text-white/70 text-sm mt-1">{{ $stat->label }}</div>
                </div>
                @endforeach

            @else
                {{-- ── Fallback statique si aucune stat en DB ── --}}
                @foreach([
                    ['icon' => '🎓', 'num' => '2 500', 'suffixe' => '+', 'label' => 'Élèves inscrits'],
                    ['icon' => '👩‍🏫', 'num' => '120',   'suffixe' => '+', 'label' => 'Enseignants'],
                    ['icon' => '🏛️', 'num' => '35',    'suffixe' => '+', 'label' => "Ans d'expérience"],
                    ['icon' => '🏆', 'num' => '98',    'suffixe' => '%', 'label' => 'Taux de réussite'],
                ] as $i => $stat)
                <div class="text-center text-white"
                     data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">
                    <div class="text-4xl mb-2" aria-hidden="true">{{ $stat['icon'] }}</div>
                    <div class="font-display text-4xl md:text-5xl font-bold" style="color:#f5c842">
                        <span class="stat-counter" data-target="{{ $stat['num'] }}">{{ $stat['num'] }}</span>{{ $stat['suffixe'] }}
                    </div>
                    <div class="text-white/70 text-sm mt-1">{{ $stat['label'] }}</div>
                </div>
                @endforeach
            @endif

        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════ --}}
{{-- 3. FORMATIONS                                       --}}
{{-- ════════════════════════════════════════════════════ --}}
<section id="formations" class="py-16 bg-white relative overflow-hidden" aria-labelledby="formations-title">
    <div class="blob w-72 h-72 -top-16 -left-16" style="background:#2952f5"></div>
    <div class="blob w-56 h-56 bottom-8 right-8"  style="background:#f5c842"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">

        <div class="text-center mb-10" data-aos="fade-up">
            <span class="section-badge">📚 Nos filières</span>
            <h2 id="formations-title"
                class="font-display text-4xl md:text-5xl font-bold mt-4 mb-4">
                Des <span class="gradient-text">formations</span><br>pour chaque ambition
            </h2>
            <p class="text-gray-500 text-lg max-w-2xl mx-auto">
                Choisissez parmi nos filières d'excellence, conçues pour préparer
                vos enfants aux métiers de demain.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @php
            $formationsData = $formations ?? collect([
                ['icon'=>'🎒','color'=>'from-blue-500 to-blue-700',      'title'=>'Cycle Primaire',       'desc'=>"Un socle solide en lecture, calcul, sciences et arts pour les 6–11 ans dans un cadre bienveillant.",'tags'=>['CP – CM2','Bilingue','Sport'],'slug'=>null,'image'=>null],
                ['icon'=>'📐','color'=>'from-purple-500 to-purple-700',  'title'=>'Collège',              'desc'=>"Accompagnement personnalisé pour développer l'esprit critique et la curiosité intellectuelle.",       'tags'=>['6ème – 3ème','Sciences','Arts'],'slug'=>null,'image'=>null],
                ['icon'=>'🔬','color'=>'from-emerald-500 to-emerald-700','title'=>'Lycée Scientifique',   'desc'=>'Mathématiques avancées, physique, SVT et préparation aux grandes écoles.',                          'tags'=>['Terminale S','Labo','TICE'],'slug'=>null,'image'=>null],
                ['icon'=>'📖','color'=>'from-orange-500 to-red-600',     'title'=>'Lycée Littéraire',     'desc'=>'Langue, philosophie, histoire et culture générale pour les esprits curieux.',                        'tags'=>['Terminale L','Débat','Théâtre'],'slug'=>null,'image'=>null],
                ['icon'=>'💻','color'=>'from-sky-500 to-indigo-600',     'title'=>'Lycée Technologique',  'desc'=>'Informatique, robotique et entrepreneuriat pour les innovateurs en herbe.',                          'tags'=>['Terminale T','Coding','Projets'],'slug'=>null,'image'=>null],
                ['icon'=>'🎓','color'=>'from-blue-700 to-blue-900',      'title'=>'Classes Préparatoires','desc'=>'MPSI, PCSI et BCPST pour intégrer les meilleures grandes écoles nationales.',                        'tags'=>['CPGE','Tutorat','Concours'],'slug'=>null,'image'=>null],
            ]);
            @endphp

            @foreach($formationsData as $i => $f)
            @php
                $isModel = is_object($f);
                $icon    = $isModel ? ($f->icon   ?? '📚') : $f['icon'];
                $color   = $isModel ? ($f->color  ?? 'from-primary-600 to-primary-800') : $f['color'];
                $title   = $isModel ? $f->titre   : $f['title'];
                $desc    = $isModel ? $f->extrait : $f['desc'];
                $tags    = $isModel ? ($f->tags   ?? []) : $f['tags'];
                $slug    = $isModel ? $f->slug    : $f['slug'];
                $image   = $isModel ? ($f->image  ?? null) : ($f['image'] ?? null);
            @endphp

            {{-- flex flex-col pour que le lien soit toujours en bas --}}
            <div class="card-hover bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden flex flex-col"
                 data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 80 }}">

                {{-- ── Photo ou dégradé de remplacement ── --}}
                <div class="relative h-48 overflow-hidden flex-shrink-0">
                    @if($image)
                        <img src="{{ asset('storage/' . $image) }}"
                             alt="{{ $title }}"
                             class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    @else
                        <div class="w-full h-full bg-gradient-to-br {{ $color }} flex items-center justify-center">
                            <span class="text-6xl opacity-40">{{ $icon }}</span>
                        </div>
                    @endif
                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r {{ $color }}"></div>
                </div>

                {{-- flex flex-col flex-1 pour occuper tout l'espace restant --}}
                <div class="p-6 flex flex-col flex-1">

                    {{-- Icône --}}
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br {{ $color }}
                                flex items-center justify-center text-xl mb-4 shadow-md -mt-10 relative z-10 border-2 border-white flex-shrink-0"
                         aria-hidden="true">
                        {{ $icon }}
                    </div>

                    <h3 class="font-display text-xl font-bold mb-2 text-dark">{{ $title }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4 line-clamp-3">{{ $desc }}</p>

                    <div class="flex flex-wrap gap-2 mb-5">
                        @foreach((array)$tags as $tag)
                        <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full font-medium">
                            {{ $tag }}
                        </span>
                        @endforeach
                    </div>

                    {{-- mt-auto pousse le lien tout en bas de la carte --}}
                    <a href="{{ $slug ? lroute('formations.show', ['slug' => $slug]) : lroute('formations') }}"
                       class="inline-flex items-center gap-1.5 text-sm font-semibold text-primary-600
                              hover:text-primary-700 group mt-auto">
                        En savoir plus
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-12" data-aos="fade-up">
            <a href="{{ lroute('formations') }}"
               class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-semibold text-sm
                      border-2 border-primary-600 text-primary-600
                      hover:bg-primary-600 hover:text-white transition-all duration-300">
                Toutes les formations
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>


{{-- ════════════════════════════════════════════════════ --}}
{{-- 4. ACTUALITÉS                                       --}}
{{-- ════════════════════════════════════════════════════ --}}
<section id="actualites" class="py-16" style="background:#f7f8fc" aria-labelledby="actu-title">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-16" data-aos="fade-up">
            <span class="section-badge">📰 Vie de l'école</span>
            <h2 id="actu-title" class="font-display text-4xl md:text-5xl font-bold mt-4 mb-6">
                Dernières <span class="gradient-text">actualités</span>
            </h2>
            <a href="{{ lroute('actualites') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-primary-600
                      hover:text-primary-700 group"
               data-aos="fade-up">
                Toutes les actualités
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @forelse($actualites ?? [] as $i => $actu)
            <article class="card-hover bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 flex flex-col"
                     data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}">

                <div class="relative overflow-hidden h-52 flex-shrink-0">
                    <img src="{{ Storage::url($actu->image) }}"
                         alt="{{ $actu->titre }}"
                         class="w-full h-full object-cover transition-transform duration-700 hover:scale-110"
                         loading="lazy">
                    <div class="absolute top-4 left-4">
                        <span class="text-xs font-semibold bg-primary-600 text-white px-3 py-1 rounded-full">
                            {{ $actu->categorie }}
                        </span>
                    </div>
                </div>

                <div class="p-6 flex flex-col flex-1">
                    <p class="text-xs text-gray-400 font-medium mb-3">
                        📅 {{ $actu->created_at->translatedFormat('d F Y') }}
                    </p>
                    <h3 class="font-display text-lg font-bold text-dark mb-2 line-clamp-2">
                        {{ $actu->titre }}
                    </h3>
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 mb-4">
                        {{ $actu->extrait }}
                    </p>
                    <a href="{{ lroute('actualites.show', ['slug' => $actu->slug]) }}"
                       class="inline-flex items-center gap-1.5 text-sm font-semibold text-primary-600
                              hover:text-primary-700 group mt-auto">
                        Lire la suite
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </article>

            @empty
            @foreach([
                ['🎉','Portes ouvertes 2025',         'Événement',    'Venez découvrir nos installations le samedi 15 mars de 9h à 17h. Inscrivez-vous en ligne.',     '15 Mar 2025'],
                ['🏆','Résultats bac 2024 : 100%',    'Résultats',    'Nos terminales ont brillé cette année avec un taux de réussite exceptionnel et 40% de mentions.','02 Juil 2024'],
                ['💻','Nouveau labo d\'informatique', 'Infrastructure','Un espace high-tech de 60 postes inauguré pour accompagner le programme NumÉdu.',              '10 Jan 2025'],
            ] as $i => [$emoji, $titre, $cat, $desc, $date])
            <article class="card-hover bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 flex flex-col"
                     data-aos="fade-up" data-aos-delay="{{ $i * 100 }}">

                <div class="h-52 flex items-center justify-center text-6xl flex-shrink-0"
                     style="background:linear-gradient(135deg,#dce6ff,#b9ccff)"
                     aria-hidden="true">
                    {{ $emoji }}
                </div>

                <div class="p-6 flex flex-col flex-1">
                    <p class="text-xs text-gray-400 font-medium mb-2">📅 {{ $date }}</p>
                    <span class="text-xs font-semibold bg-primary-50 text-primary-600 px-3 py-1 rounded-full self-start">
                        {{ $cat }}
                    </span>
                    <h3 class="font-display text-lg font-bold text-dark mt-3 mb-2">{{ $titre }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 mb-4">{{ $desc }}</p>
                    <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-primary-400 cursor-default mt-auto">
                        Bientôt disponible
                    </span>
                </div>
            </article>
            @endforeach
            @endforelse

        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════ --}}
{{-- 5. GALERIE                                          --}}
{{-- ════════════════════════════════════════════════════ --}}
<section id="galerie" class="py-16 bg-white" aria-labelledby="galerie-title">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-16" data-aos="fade-up">
            <span class="section-badge">🖼️ Campus &amp; événements</span>
            <h2 id="galerie-title" class="font-display text-4xl md:text-5xl font-bold mt-4 mb-4">
                Notre <span class="gradient-text">galerie</span>
            </h2>
            <p class="text-gray-500 text-lg max-w-xl mx-auto">
                Plongez dans l'atmosphère unique de notre établissement.
            </p>
        </div>

        <div class="swiper gallery-swiper overflow-hidden" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">

                @forelse($galerie ?? [] as $photo)
                <div class="swiper-slide">
                    <div class="relative group overflow-hidden rounded-2xl shadow-md">
                        <img src="{{ Storage::url($photo->image) }}"
                             alt="{{ $photo->legende ?? 'Photo galerie' }}"
                             class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-110"
                             loading="lazy">
                        @if($photo->legende)
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent
                                    opacity-0 group-hover:opacity-100 transition-opacity duration-300
                                    flex items-end p-4">
                            <span class="text-white text-sm font-medium">{{ $photo->legende }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                @empty
                @foreach([
                    ['from-blue-400 to-blue-600',     '🏫', 'Bâtiment principal'],
                    ['from-emerald-400 to-emerald-600','⚽', 'Terrain de sport'],
                    ['from-purple-400 to-purple-600',  '🔬', 'Laboratoire'],
                    ['from-orange-400 to-red-500',     '📚', 'Bibliothèque'],
                    ['from-sky-400 to-indigo-600',     '💻', 'Salle informatique'],
                    ['from-pink-400 to-rose-600',      '🎭', 'Salle des fêtes'],
                ] as [$grad, $emoji, $leg])
                <div class="swiper-slide">
                    <div class="relative group overflow-hidden rounded-2xl shadow-md">
                        <div class="w-full h-56 bg-gradient-to-br {{ $grad }}
                                    flex items-center justify-center">
                            <span class="text-6xl" aria-hidden="true">{{ $emoji }}</span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent
                                    opacity-0 group-hover:opacity-100 transition-opacity duration-300
                                    flex items-end p-4">
                            <span class="text-white text-sm font-medium">{{ $leg }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
                @endforelse

            </div>
            <div class="swiper-pagination"></div>
        </div>

        <div class="text-center mt-10" data-aos="fade-up">
            <a href="{{ lroute('galerie') }}"
               class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-semibold text-sm
                      bg-gradient-to-r from-primary-600 to-primary-500 text-white
                      shadow-lg hover:-translate-y-1 transition-all duration-300"
               style="box-shadow:0 8px 24px rgba(41,82,245,.3)">
                Voir toute la galerie
            </a>
        </div>
    </div>
</section>
{{-- ════════════════════════════════════════════════════ --}}
{{-- 6. TÉMOIGNAGES                                      --}}
{{-- ════════════════════════════════════════════════════ --}}
<section class="py-16 overflow-hidden" style="background:#f7f8fc" aria-labelledby="temoignages-title">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-16" data-aos="fade-up">
            <span class="section-badge">💬 Témoignages</span>
            <h2 id="temoignages-title" class="font-display text-4xl md:text-5xl font-bold mt-4">
                Ils nous font <span class="gradient-text">confiance</span>
            </h2>
        </div>

        <div class="swiper testimonials-swiper" data-aos="fade-up" data-aos-delay="100">
            <div class="swiper-wrapper">

                @php
                $temoignagesData = ($temoignages && $temoignages->count()) ? $temoignages : collect([
                    ['nom'=>'Sophie M.',   'role'=>"Parent d'élève",    'texte'=>"Mon fils a progressé de façon remarquable. L'équipe pédagogique est à l'écoute et très professionnelle.", 'note'=>5, 'photo'=>null],
                    ['nom'=>'Karim D.',    'role'=>'Ancien élève',       'texte'=>"Grâce à EduSmart, j'ai intégré Polytechnique. Les classes prépa sont d'un niveau exceptionnel.",           'note'=>5, 'photo'=>null],
                    ['nom'=>'Marie L.',    'role'=>"Parent d'élève",    'texte'=>"Un cadre bienveillant, des activités extra-scolaires variées. Mes enfants adorent venir à l'école.",        'note'=>5, 'photo'=>null],
                    ['nom'=>'Thomas R.',   'role'=>'Élève de Terminale', 'texte'=>"Les professeurs sont passionnants et nous préparent vraiment aux défis de la vie.",                         'note'=>5, 'photo'=>null],
                ]);
                @endphp

                @foreach($temoignagesData as $t)
                @php
                    $isModel = is_object($t);
                    $nom     = $isModel ? $t->nom             : $t['nom'];
                    $role    = $isModel ? $t->role            : $t['role'];
                    $texte   = $isModel ? $t->texte           : $t['texte'];
                    $note    = $isModel ? ($t->note ?? 5)     : ($t['note'] ?? 5);
                    $photo   = $isModel ? ($t->photo ?? null) : ($t['photo'] ?? null);
                @endphp
                <div class="swiper-slide">
                    <div class="temoignage-card bg-white rounded-2xl p-8 shadow-sm border-2 border-transparent mx-2 flex flex-col items-center text-center">

                        {{-- Photo ou initiale --}}
                        <div class="mb-4">
                            @if($photo)
                                <img src="{{ Storage::url($photo) }}"
                                     alt="{{ $nom }}"
                                     class="temoignage-photo w-20 h-20 rounded-full object-cover border-4 border-yellow-100 shadow-md mx-auto">
                            @else
                                <div class="w-20 h-20 rounded-full flex items-center justify-center
                                            text-white font-bold text-2xl mx-auto border-4 border-yellow-100 shadow-md"
                                     style="background:linear-gradient(135deg,#2952f5,#152dd4)">
                                    {{ mb_substr($nom, 0, 1) }}
                                </div>
                            @endif
                        </div>

                        {{-- Étoiles --}}
                        <div class="flex gap-0.5 mb-4 justify-center" aria-label="Note : {{ $note }}/5">
                            @for($s = 1; $s <= 5; $s++)
                            <svg class="w-4 h-4 {{ $s <= $note ? 'text-yellow-400' : 'text-gray-200' }}"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                        </div>

                        {{-- Texte --}}
                        <p class="text-gray-600 text-sm leading-relaxed mb-6 italic flex-1">
                            "{{ $texte }}"
                        </p>

                        {{-- Nom & rôle --}}
                        <div>
                            <p class="font-bold text-sm" style="color:#0d1224">{{ $nom }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $role }}</p>
                        </div>

                    </div>
                </div>
                @endforeach

            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════ --}}
{{-- 7. CTA RENTRÉE SCOLAIRE — DYNAMIQUE DEPUIS LA DB    --}}
{{-- ════════════════════════════════════════════════════ --}}
@if(isset($rentree) && $rentree)
{{-- ── Version dynamique depuis la DB ── --}}
<section class="py-16 relative overflow-hidden"
         style="background:linear-gradient(135deg,#152dd4 0%,#1a3de8 50%,#0d1224 100%)"
         aria-labelledby="cta-title">
    <div class="blob w-96 h-96 -top-20 -right-20" style="background:#f5c842"></div>
    <div class="blob w-64 h-64 bottom-0 left-8"   style="background:#2952f5"></div>

    <div class="max-w-4xl mx-auto px-4 text-center relative" data-aos="zoom-in">

        @if($rentree->badge_label)
        <span class="inline-block text-sm font-semibold tracking-widest uppercase
                     rounded-full px-5 py-1.5 mb-6"
              style="color:#f5c842;border:1px solid rgba(245,200,66,.35)">
            🗓️ {{ $rentree->badge_label }}
        </span>
        @endif

        <h2 id="cta-title"
            class="font-display text-4xl md:text-6xl font-bold text-white mb-6">
            {{ $rentree->titre }}<br>
            <span style="background:linear-gradient(135deg,#f5c842,#e8b014);
                         -webkit-background-clip:text;-webkit-text-fill-color:transparent;
                         background-clip:text;">
                {{ $rentree->annee }}
            </span>
        </h2>

        @if($rentree->description)
        <p class="text-white/70 text-lg mb-10 max-w-2xl mx-auto">
            {{ $rentree->description }}
        </p>
        @endif

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @if($rentree->btn1_label)
            <a href="{{ $rentree->btn1_url ?? lroute('preinscription') }}"
               class="inline-flex items-center gap-2.5 px-10 py-4 rounded-xl font-bold text-base
                      text-dark hover:-translate-y-1 transition-all duration-300"
               style="background:linear-gradient(135deg,#f5c842,#e8b014);
                      box-shadow:0 8px 32px rgba(245,200,66,.35)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                {{ $rentree->btn1_label }}
            </a>
            @endif
            @if($rentree->btn2_label)
            <a href="{{ $rentree->btn2_url ?? lroute('contact') }}"
               class="inline-flex items-center gap-2.5 px-10 py-4 rounded-xl font-semibold text-base
                      text-white border border-white/25 backdrop-blur-sm
                      hover:bg-white/10 hover:-translate-y-1 transition-all duration-300">
                {{ $rentree->btn2_label }}
            </a>
            @endif
        </div>
    </div>
</section>

@else
{{-- ── Fallback statique si aucune rentrée active en DB ── --}}
<section class="py-20 relative overflow-hidden"
         style="background:linear-gradient(135deg,#152dd4 0%,#1a3de8 50%,#0d1224 100%)"
         aria-labelledby="cta-title">
    <div class="blob w-96 h-96 -top-20 -right-20" style="background:#f5c842"></div>
    <div class="blob w-64 h-64 bottom-0 left-8"   style="background:#2952f5"></div>

    <div class="max-w-4xl mx-auto px-4 text-center relative" data-aos="zoom-in">
        <span class="inline-block text-sm font-semibold tracking-widest uppercase
                     rounded-full px-5 py-1.5 mb-6"
              style="color:#f5c842;border:1px solid rgba(245,200,66,.35)">
            🗓️ Inscriptions ouvertes
        </span>
        <h2 id="cta-title"
            class="font-display text-4xl md:text-6xl font-bold text-white mb-6">
            Préparez la rentrée<br>
            <span style="background:linear-gradient(135deg,#f5c842,#e8b014);
                         -webkit-background-clip:text;-webkit-text-fill-color:transparent;
                         background-clip:text;">
                2025–2026
            </span>
        </h2>
        <p class="text-white/70 text-lg mb-10 max-w-2xl mx-auto">
            Complétez votre dossier de préinscription en ligne en moins de 5 minutes.
            Places limitées — ne tardez pas !
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ lroute('preinscription') }}"
               class="inline-flex items-center gap-2.5 px-10 py-4 rounded-xl font-bold text-base
                      text-dark hover:-translate-y-1 transition-all duration-300"
               style="background:linear-gradient(135deg,#f5c842,#e8b014);
                      box-shadow:0 8px 32px rgba(245,200,66,.35)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
                Déposer ma candidature
            </a>
            <a href="{{ lroute('contact') }}"
               class="inline-flex items-center gap-2.5 px-10 py-4 rounded-xl font-semibold text-base
                      text-white border border-white/25 backdrop-blur-sm
                      hover:bg-white/10 hover:-translate-y-1 transition-all duration-300">
                Nous contacter
            </a>
        </div>
    </div>
</section>
@endif

@endsection

<style>
/* ══════════════════════════════════════════════════════ */
/* TÉMOIGNAGES                                           */
/* ══════════════════════════════════════════════════════ */
.temoignage-card {
    transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
    cursor: default;
}
.temoignage-card:hover {
    transform: scale(1.03);
    border-color: #facc15;
    box-shadow: 0 12px 32px rgba(250, 204, 21, 0.25);
}
.temoignage-photo {
    transition: transform 0.3s ease, border-color 0.3s ease;
}
.temoignage-card:hover .temoignage-photo {
    transform: scale(1.10);
    border-color: #facc15;
}
.testimonials-swiper {
    overflow: hidden !important;
    padding-bottom: 48px !important;
}
.testimonials-swiper .swiper-wrapper {
    padding-bottom: 0 !important;
    overflow: visible;
}
.testimonials-swiper .swiper-slide {
    height: auto !important;
}

/* ══════════════════════════════════════════════════════ */
/* ÉQUIPE                                                */
/* ══════════════════════════════════════════════════════ */

/* ── Carte équipe ── */
.equipe-card {
    transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
    cursor: default;
}
.equipe-card:hover {
    transform: scale(1.03);
    border-color: #facc15;
    box-shadow: 0 12px 32px rgba(250, 204, 21, 0.25);
}

/* ── Photo équipe ── */
.equipe-photo {
    transition: transform 0.3s ease, border-color 0.3s ease;
}
.equipe-card:hover .equipe-photo {
    transform: scale(1.10);
    border-color: #facc15;
}


/* ══════════════════════════════════════════════════════ */
/* GALERIE                                               */
/* ══════════════════════════════════════════════════════ */

/* ── Fix hauteur et vide galerie ── */
.gallery-swiper {
    height: auto !important;
    min-height: 280px;
    padding-bottom: 40px !important;
}

.gallery-swiper .swiper-wrapper {
    height: auto !important;
    align-items: stretch;
}

.gallery-swiper .swiper-slide {
    height: auto !important;
}

.gallery-swiper .swiper-slide img,
.gallery-swiper .swiper-slide > div {
    height: 224px !important;
    width: 100%;
}
</style>

@push('scripts')
<script>
// ── Animation compteurs statistiques ──────────────────
const animateCounters = () => {
    document.querySelectorAll('.stat-counter').forEach(counter => {
        // Réinitialise à 0 avant chaque animation
        counter.textContent = '0';
        const target = parseFloat(counter.getAttribute('data-target').replace(/\s/g, ''));
        const duration = 2000;
        const steps = 60;
        const increment = target / steps;
        let current = 0;
        let step = 0;
        const timer = setInterval(() => {
            step++;
            current = Math.min(increment * step, target);
            const formatted = current >= 1000
                ? Math.floor(current).toLocaleString('fr-FR')
                : Number.isInteger(target)
                    ? Math.floor(current)
                    : current.toFixed(0);
            counter.textContent = formatted;
            if (step >= steps) clearInterval(timer);
        }, duration / steps);
    });
};

const statsSection = document.querySelector('.stats-section');
if (statsSection) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                // ✅ observer.unobserve retiré → animation à chaque scroll
            }
        });
    }, { threshold: 0.3 });
    observer.observe(statsSection);
}

// ── Swiper Témoignages ─────────────────────────────────
const testimonialSwiper = new Swiper('.testimonials-swiper', {
    slidesPerView: 1,
    spaceBetween: 24,
    loop: true,
    autoHeight: true,
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.testimonials-swiper .swiper-pagination',
        clickable: true,
    },
    breakpoints: {
        640: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
    },
});
</script>
@endpush