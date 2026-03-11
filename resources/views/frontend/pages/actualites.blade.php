@extends('frontend.layout.frontend')

@section('title', config('school.name') . ' — Actualités')

@section('content')

{{-- ════════════════════════════════════════════════════ --}}
{{-- HERO — DYNAMIQUE                                    --}}
{{-- ════════════════════════════════════════════════════ --}}
<section class="relative py-32 overflow-hidden"
         style="{{ $hero->image
            ? 'background-image:url(' . image_url($hero->image) . ');background-size:cover;background-position:center;'
            : 'background:linear-gradient(135deg,#0d1224 0%,#192686 60%,#0d1224 100%)' }}">

    @if($hero->image)
    <div class="absolute inset-0" style="background:rgba(13,18,36,0.72)"></div>
    @endif

    <div class="blob w-96 h-96 top-0 right-0" style="background:#f5c842"></div>
    <div class="blob w-64 h-64 bottom-0 left-0" style="background:#2952f5"></div>

    <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
        <span class="section-badge mb-4"
              style="background:rgba(255,255,255,0.1);color:#f5c842;border-color:rgba(245,200,66,0.3)">
            📰 Vie de l'école
        </span>
        <h1 class="font-display text-5xl md:text-6xl font-bold text-white mt-4 mb-6">
            Nos <span style="background:linear-gradient(135deg,#f5c842,#e8b014);
                             -webkit-background-clip:text;-webkit-text-fill-color:transparent;
                             background-clip:text;">actualités</span>
        </h1>
        <p class="text-white/70 text-lg max-w-2xl mx-auto">
            Restez informés de toute la vie de notre établissement.
        </p>
    </div>
</section>

{{-- ACTUALITÉS --}}
<section class="py-24" style="background:#f7f8fc">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($categories->isNotEmpty())
        <div class="flex flex-wrap gap-2 mb-10 justify-center" data-aos="fade-up">
            <a href="{{ lroute('actualites') }}"
               class="px-4 py-2 rounded-full text-sm font-semibold transition-all
                      {{ !request('categorie')
                          ? 'bg-primary-600 text-white shadow-md'
                          : 'bg-white text-gray-600 border border-gray-200 hover:border-primary-400' }}">
                Toutes
            </a>
            @foreach($categories as $cat)
            <a href="{{ lroute('actualites', ['categorie' => $cat]) }}"
               class="px-4 py-2 rounded-full text-sm font-semibold transition-all
                      {{ request('categorie') == $cat
                          ? 'bg-primary-600 text-white shadow-md'
                          : 'bg-white text-gray-600 border border-gray-200 hover:border-primary-400' }}">
                {{ $cat }}
            </a>
            @endforeach
        </div>
        @endif

        @if($actualites->isEmpty())
        <div class="text-center py-20">
            <div class="text-6xl mb-4">📰</div>
            <h3 class="font-display text-2xl font-bold text-gray-700 mb-2">Aucune actualité pour le moment</h3>
            <p class="text-gray-400">Revenez prochainement.</p>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($actualites as $i => $actu)
            <article class="card-hover bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100"
                     data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}">
                <div class="relative overflow-hidden h-52">
                    <img src="{{ image_url($actu->image) }}"
                         alt="{{ $actu->titre }}"
                         class="w-full h-full object-cover transition-transform duration-700 hover:scale-110"
                         loading="lazy">
                    <div class="absolute top-4 left-4">
                        <span class="text-xs font-semibold bg-primary-600 text-white px-3 py-1 rounded-full">
                            {{ $actu->categorie }}
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-xs text-gray-400 font-medium mb-3">
                        📅 {{ $actu->published_at?->translatedFormat('d F Y') }}
                    </p>
                    <h3 class="font-display text-lg font-bold text-dark mb-2 line-clamp-2">{{ $actu->titre }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 mb-4">{{ $actu->extrait }}</p>
                    <a href="{{ lroute('actualites.show', ['slug' => $actu->slug]) }}"
                       class="inline-flex items-center gap-1.5 text-sm font-semibold
                              text-primary-600 hover:text-primary-700 group">
                        Lire la suite
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </article>
            @endforeach
        </div>

        @if($actualites->hasPages())
        <div class="mt-12 flex justify-center">{{ $actualites->links() }}</div>
        @endif
        @endif

    </div>
</section>

@endsection