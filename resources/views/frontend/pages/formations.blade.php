@extends('frontend.layout.frontend')

@section('title', config('school.name') . ' — ' . __('formations.hero_title_accent'))

@section('content')

{{-- ════════════════════════════════════════════════════ --}}
{{-- HERO                                                --}}
{{-- ════════════════════════════════════════════════════ --}}
<section class="relative py-32 overflow-hidden"
         style="{{ $hero->image
            ? 'background-image:url(' . Storage::url($hero->image) . ');background-size:cover;background-position:center;'
            : 'background:linear-gradient(135deg,#0d1224 0%,#192686 60%,#0d1224 100%)' }}">

    @if($hero->image)
    <div class="absolute inset-0" style="background:rgba(13,18,36,0.72)"></div>
    @endif

    <div class="blob w-96 h-96 top-0 right-0" style="background:#f5c842"></div>
    <div class="blob w-64 h-64 bottom-0 left-0" style="background:#2952f5"></div>

    <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
        <span class="section-badge mb-4"
              style="background:rgba(255,255,255,0.1);color:#f5c842;border-color:rgba(245,200,66,0.3)">
            {{ __('formations.hero_badge') }}
        </span>
        <h1 class="font-display text-5xl md:text-6xl font-bold text-white mt-4 mb-6">
            {{ __('formations.hero_title') }}
            <span style="background:linear-gradient(135deg,#f5c842,#e8b014);
                         -webkit-background-clip:text;-webkit-text-fill-color:transparent;
                         background-clip:text;">{{ __('formations.hero_title_accent') }}</span>
        </h1>
        <p class="text-white/70 text-lg max-w-2xl mx-auto">
            {{ __('formations.hero_subtitle') }}
        </p>
    </div>
</section>

{{-- ════════════════════════════════════════════════════ --}}
{{-- FORMATIONS                                          --}}
{{-- ════════════════════════════════════════════════════ --}}
<section class="py-24 relative overflow-hidden" style="background:#f0f4ff">
    <div class="blob w-72 h-72 -top-16 -left-16" style="background:#2952f5"></div>
    <div class="blob w-56 h-56 bottom-8 right-8"  style="background:#f5c842"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">

        @if($formations->isEmpty())
        <div class="text-center py-20">
            <div class="text-6xl mb-4">📚</div>
            <h3 class="font-display text-2xl font-bold text-gray-700 mb-2">
                {{ __('formations.empty_title') }}
            </h3>
            <p class="text-gray-400">{{ __('formations.empty_subtitle') }}</p>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($formations as $i => $f)
            @php
                preg_match('/from-([\w-]+)/', $f->color ?? 'from-blue-600', $m);
                $colorKey = $m[1] ?? 'blue-600';
                $gradientMap = [
                    'blue-500'    => ['#3b82f6','#1d4ed8'],
                    'blue-600'    => ['#2563eb','#1e40af'],
                    'blue-700'    => ['#1d4ed8','#1e3a8a'],
                    'blue-900'    => ['#1e3a8a','#0d1224'],
                    'purple-500'  => ['#a855f7','#7c3aed'],
                    'purple-600'  => ['#9333ea','#6d28d9'],
                    'emerald-500' => ['#10b981','#059669'],
                    'emerald-600' => ['#059669','#047857'],
                    'orange-500'  => ['#f97316','#ea580c'],
                    'red-600'     => ['#dc2626','#b91c1c'],
                    'sky-500'     => ['#0ea5e9','#0284c7'],
                    'indigo-600'  => ['#4f46e5','#4338ca'],
                    'green-500'   => ['#22c55e','#16a34a'],
                    'pink-500'    => ['#ec4899','#db2777'],
                    'teal-500'    => ['#14b8a6','#0d9488'],
                    'yellow-500'  => ['#eab308','#ca8a04'],
                ];
                $colors = $gradientMap[$colorKey] ?? ['#2952f5','#152dd4'];
                $c1 = $colors[0];
                $c2 = $colors[1];
            @endphp

            <div class="group relative rounded-2xl overflow-hidden shadow-lg cursor-pointer
                        transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl"
                 data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 80 }}"
                 style="background:linear-gradient(135deg, {{ $c1 }} 0%, {{ $c2 }} 100%)">

                {{-- Motif décoratif --}}
                <div class="absolute inset-0 opacity-10" style="
                    background-image: radial-gradient(circle at 20% 20%, white 1px, transparent 1px),
                                      radial-gradient(circle at 80% 80%, white 1px, transparent 1px);
                    background-size: 30px 30px;"></div>
                <div class="absolute -right-8 -top-8 w-36 h-36 rounded-full opacity-10"
                     style="background:white"></div>
                <div class="absolute -left-4 -bottom-4 w-24 h-24 rounded-full opacity-10"
                     style="background:white"></div>

                {{-- Contenu --}}
                <div class="relative z-10 p-7">

                    {{-- Header : icône + numéro --}}
                    <div class="flex items-start justify-between mb-5">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl
                                    shadow-lg border-2 border-white/20"
                             style="background:rgba(255,255,255,0.15);backdrop-filter:blur(8px)">
                            {{ $f->icon ?? '📚' }}
                        </div>
                        <span class="text-white/30 font-bold text-4xl font-display leading-none">
                            {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    {{-- Titre — Spatie retourne automatiquement FR ou EN --}}
                    <h3 class="font-display text-xl font-bold text-white mb-2 leading-tight">
                        {{ $f->titre }}
                    </h3>

                    {{-- Extrait --}}
                    <p class="text-white/70 text-sm leading-relaxed mb-5 line-clamp-3">
                        {{ $f->extrait }}
                    </p>

                    {{-- Tags --}}
                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach(($f->tags ?? []) as $tag)
                        <span class="text-xs font-semibold px-3 py-1 rounded-full border border-white/25"
                              style="background:rgba(255,255,255,0.12);color:rgba(255,255,255,0.9)">
                            {{ $tag }}
                        </span>
                        @endforeach
                    </div>

                    <div class="border-t border-white/15 mb-4"></div>

                    {{-- CTA --}}
                    <a href="{{ lroute('formations.show', ['slug' => $f->slug]) }}"
                       class="inline-flex items-center gap-2 text-sm font-bold text-white
                              group-hover:gap-3 transition-all duration-300">
                        {{ __('formations.cta_decouvrir') }}
                        <span class="w-7 h-7 rounded-full flex items-center justify-center
                                     transition-all duration-300 group-hover:scale-110"
                              style="background:rgba(255,255,255,0.2)">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </a>
                </div>

            </div>
            @endforeach
        </div>

        @if($formations->hasPages())
        <div class="mt-12 flex justify-center">{{ $formations->links() }}</div>
        @endif
        @endif

    </div>
</section>

{{-- ════════════════════════════════════════════════════ --}}
{{-- CTA                                                 --}}
{{-- ════════════════════════════════════════════════════ --}}
<section class="py-20 relative overflow-hidden"
         style="background:linear-gradient(135deg,#152dd4 0%,#1a3de8 50%,#0d1224 100%)">
    <div class="max-w-4xl mx-auto px-4 text-center relative z-10" data-aos="zoom-in">
        <h2 class="font-display text-4xl font-bold text-white mb-4">
            {{ __('formations.cta_title') }}
            <span style="background:linear-gradient(135deg,#f5c842,#e8b014);
                         -webkit-background-clip:text;-webkit-text-fill-color:transparent;
                         background-clip:text;">{{ __('formations.cta_title_accent') }}</span>
        </h2>
        <p class="text-white/70 mb-8 text-lg">
            {{ __('formations.cta_subtitle') }}
        </p>
        <a href="{{ lroute('preinscription') }}"
           class="inline-flex items-center gap-2 px-10 py-4 rounded-xl font-bold text-sm
                  text-dark hover:-translate-y-1 transition-all duration-300"
           style="background:linear-gradient(135deg,#f5c842,#e8b014);
                  box-shadow:0 8px 32px rgba(245,200,66,0.35)">
            {{ __('formations.cta_btn') }}
        </a>
    </div>
</section>

@endsection