@extends('frontend.layout.frontend')

@section('title', $actualite->titre . ' — ' . config('school.name'))

@section('content')

{{-- HERO --}}
<section class="relative py-28 overflow-hidden"
         style="background:linear-gradient(135deg,#0d1224 0%,#192686 60%,#0d1224 100%)">
    <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
        <a href="{{ lroute('actualites') }}"
           class="inline-flex items-center gap-2 text-white/50 hover:text-white text-sm mb-6 transition-colors">
            ← Toutes les actualités
        </a>
        <span class="inline-block text-xs font-semibold bg-primary-600 text-white
                     px-3 py-1 rounded-full mb-4">
            {{ $actualite->categorie }}
        </span>
        <h1 class="font-display text-3xl md:text-5xl font-bold text-white mb-4">
            {{ $actualite->titre }}
        </h1>
        <p class="text-white/50 text-sm">
            📅 {{ $actualite->published_at?->translatedFormat('d F Y') }}
        </p>
    </div>
</section>

{{-- CONTENU --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            {{-- Article --}}
            <div class="lg:col-span-2">
                <img src="{{ image_url($actualite->image) }}"
                     alt="{{ $actualite->titre }}"
                     class="w-full h-72 object-cover rounded-2xl mb-8 shadow-md">

                <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed">
                    {!! nl2br(e($actualite->contenu)) !!}
                </div>

                {{-- Partage --}}
                <div class="mt-10 pt-8 border-t border-gray-100 flex items-center gap-4">
                    <span class="text-sm font-semibold text-gray-500">Partager :</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                       target="_blank"
                       class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center
                              text-white hover:-translate-y-1 transition-all text-xs font-bold">
                        f
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($actualite->titre) }}"
                       target="_blank"
                       class="w-9 h-9 rounded-lg bg-black flex items-center justify-center
                              text-white hover:-translate-y-1 transition-all text-xs font-bold">
                        𝕏
                    </a>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">

                {{-- Actualités récentes --}}
                @if($recentes->isNotEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="font-display font-bold text-gray-800 mb-4">
                        Actualités récentes
                    </h3>
                    <div class="space-y-4">
                        @foreach($recentes as $r)
                        <a href="{{ lroute('actualites.show', ['slug' => $r->slug]) }}"
                           class="flex gap-3 group">
                            <img src="{{ image_url($r->image) }}"
                                 alt="{{ $r->titre }}"
                                 class="w-16 h-12 object-cover rounded-lg flex-shrink-0">
                            <div>
                                <p class="text-sm font-semibold text-gray-800
                                          group-hover:text-blue-600 transition-colors line-clamp-2">
                                    {{ $r->titre }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $r->published_at?->format('d/m/Y') }}
                                </p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- CTA --}}
                <div class="rounded-2xl p-6 text-white text-center"
                     style="background:linear-gradient(135deg,#2952f5,#152dd4)">
                    <div class="text-3xl mb-3">✏️</div>
                    <h3 class="font-display font-bold mb-2">Préinscription</h3>
                    <p class="text-white/70 text-sm mb-4">
                        Inscriptions ouvertes pour la rentrée prochaine.
                    </p>
                    <a href="{{ lroute('preinscription') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm
                              font-bold text-dark hover:-translate-y-1 transition-all"
                       style="background:linear-gradient(135deg,#f5c842,#e8b014)">
                        Déposer un dossier
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection