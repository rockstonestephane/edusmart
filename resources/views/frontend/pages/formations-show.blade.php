@extends('frontend.layout.frontend')

@section('title', $formation->titre . ' — ' . config('school.name'))

@section('content')

{{-- HERO --}}
<section class="relative py-28 overflow-hidden"
         style="background:linear-gradient(135deg,#0d1224 0%,#192686 60%,#0d1224 100%)">
    <div class="max-w-4xl mx-auto px-4 text-center relative z-10">
        <a href="{{ lroute('formations') }}"
           class="inline-flex items-center gap-2 text-white/50 hover:text-white text-sm mb-6 transition-colors">
            ← Toutes les formations
        </a>
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $formation->color ?? 'from-blue-500 to-blue-700' }}
                    flex items-center justify-center text-3xl mx-auto mb-4 shadow-xl">
            {{ $formation->icon ?? '📚' }}
        </div>
        <h1 class="font-display text-4xl md:text-5xl font-bold text-white mb-4">
            {{ $formation->titre }}
        </h1>
        <div class="flex flex-wrap gap-2 justify-center">
            @foreach(($formation->tags ?? []) as $tag)
            <span class="text-xs font-semibold px-3 py-1 rounded-full"
                  style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8)">
                {{ $tag }}
            </span>
            @endforeach
        </div>
    </div>
</section>

{{-- CONTENU --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            {{-- Contenu principal --}}
            <div class="lg:col-span-2">
                @if($formation->image)
                <img src="{{ Storage::url($formation->image) }}"
                     alt="{{ $formation->titre }}"
                     class="w-full h-72 object-cover rounded-2xl mb-8 shadow-md">
                @endif

                <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed">
                    @if($formation->contenu)
                        {!! nl2br(e($formation->contenu)) !!}
                    @else
                        <p>{{ $formation->extrait }}</p>
                    @endif
                </div>

                <div class="mt-8">
                    <a href="{{ lroute('preinscription') }}"
                       class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-bold text-sm text-white
                              hover:-translate-y-1 transition-all duration-300"
                       style="background:linear-gradient(135deg,#2952f5,#152dd4);
                              box-shadow:0 8px 24px rgba(41,82,245,0.3)">
                        ✏️ S'inscrire à cette formation
                    </a>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">

                {{-- Tags --}}
                @if(!empty($formation->tags))
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h3 class="font-display font-bold text-gray-800 mb-3">Points clés</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($formation->tags as $tag)
                        <span class="text-sm bg-white border border-gray-200 text-gray-600
                                     px-3 py-1.5 rounded-full font-medium">
                            ✓ {{ $tag }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Contact --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="font-display font-bold text-gray-800 mb-4">
                        Une question ?
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">
                        Notre équipe pédagogique est à votre disposition.
                    </p>
                    <a href="{{ lroute('contact') }}"
                       class="inline-flex items-center gap-2 w-full justify-center px-4 py-3
                              rounded-xl text-sm font-semibold text-white transition-all hover:-translate-y-1"
                       style="background:linear-gradient(135deg,#2952f5,#152dd4)">
                        ✉️ Nous contacter
                    </a>
                </div>

                {{-- Autres formations --}}
                @if($autres->isNotEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="font-display font-bold text-gray-800 mb-4">
                        Autres formations
                    </h3>
                    <div class="space-y-3">
                        @foreach($autres as $autre)
                        <a href="{{ lroute('formations.show', ['slug' => $autre->slug]) }}"
                           class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition-colors group">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $autre->color ?? 'from-blue-500 to-blue-700' }}
                                        flex items-center justify-center text-lg flex-shrink-0">
                                {{ $autre->icon ?? '📚' }}
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">
                                    {{ $autre->titre }}
                                </div>
                                <div class="text-xs text-gray-400 truncate">
                                    {{ Str::limit($autre->extrait, 40) }}
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</section>

@endsection