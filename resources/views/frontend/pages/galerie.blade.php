@extends('frontend.layout.frontend')

@section('title', config('school.name') . ' — Galerie')

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

    <div class="max-w-4xl mx-auto px-4 te8xt-center relative z-10">
        <span class="section-badge mb-4"
              style="background:rgba(255,255,255,0.1);color:#f5c842;border-color:rgba(245,200,66,0.3)">
            🎨 Campus &amp; événements
        </span>
        <h1 class="font-display text-5xl md:text-6xl font-bold text-white mt-4 mb-6">
            Notre <span style="background:linear-gradient(135deg,#f5c842,#e8b014);
                               -webkit-background-clip:text;-webkit-text-fill-color:transparent;
                               background-clip:text;">galerie</span>
        </h1>
        <p class="text-white/70 text-lg max-w-2xl mx-auto">
            Plongez dans l'atmosphère unique de notre établissement.
        </p>
    </div>
</section>

{{-- GALERIE --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($categories->isNotEmpty())
        <div class="flex flex-wrap gap-2 mb-10 justify-center" data-aos="fade-up">
            <a href="{{ lroute('galerie') }}"
               class="px-4 py-2 rounded-full text-sm font-semibold transition-all
                      {{ !request('categorie') ? 'text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:border-primary-400' }}"
               style="{{ !request('categorie') ? 'background:linear-gradient(135deg,#2952f5,#152dd4)' : '' }}">
                Toutes
            </a>
            @foreach($categories as $cat)
            <a href="{{ lroute('galerie', ['categorie' => $cat]) }}"
               class="px-4 py-2 rounded-full text-sm font-semibold transition-all
                      {{ request('categorie') == $cat ? 'text-white shadow-md' : 'bg-white text-gray-600 border border-gray-200 hover:border-primary-400' }}"
               style="{{ request('categorie') == $cat ? 'background:linear-gradient(135deg,#2952f5,#152dd4)' : '' }}">
                {{ $cat }}
            </a>
            @endforeach
        </div>
        @endif

        @if($photos->isEmpty())
        <div class="text-center py-20">
            <div class="text-6xl mb-4">🎨</div>
            <h3 class="font-display text-2xl font-bold text-gray-700 mb-2">Galerie bientôt disponible</h3>
            <p class="text-gray-400">Revenez prochainement.</p>
        </div>
        @else
        <div class="columns-1 sm:columns-2 lg:columns-3 gap-4 space-y-4" data-aos="fade-up">
            @foreach($photos as $photo)
            <div class="break-inside-avoid group relative overflow-hidden rounded-2xl shadow-md cursor-pointer"
                 onclick="openLightbox('{{ image_url($photo->image) }}', '{{ $photo->legende ?? '' }}')">
                <img src="{{ image_url($photo->image) }}"
                     alt="{{ $photo->legende ?? 'Photo galerie' }}"
                     class="w-full object-cover transition-transform duration-500 group-hover:scale-105"
                     loading="lazy">
                <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300
                            flex items-end p-4"
                     style="background:linear-gradient(to top, rgba(13,18,36,0.8) 0%, transparent 60%)">
                    <div>
                        @if($photo->legende)
                        <p class="text-white text-sm font-medium">{{ $photo->legende }}</p>
                        @endif
                        @if($photo->categorie)
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full mt-1 inline-block"
                              style="background:rgba(245,200,66,0.3);color:#f5c842">
                            {{ $photo->categorie }}
                        </span>
                        @endif
                    </div>
                    <div class="ml-auto">
                        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($photos->hasPages())
        <div class="mt-12 flex justify-center">{{ $photos->links() }}</div>
        @endif
        @endif

    </div>
</section>

{{-- LIGHTBOX --}}
<div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     style="background:rgba(0,0,0,0.92)" onclick="closeLightbox()">
    <button onclick="closeLightbox()"
            class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 flex items-center
                   justify-center text-white hover:bg-white/20 transition-colors z-10">✕</button>
    <img id="lightbox-img" src="" alt=""
         class="max-w-full max-h-[85vh] object-contain rounded-2xl shadow-2xl"
         onclick="event.stopPropagation()">
    <p id="lightbox-caption" class="absolute bottom-6 left-1/2 -translate-x-1/2 text-white/70 text-sm"></p>
</div>

@endsection

@push('scripts')
<script>
function openLightbox(src, caption) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox-caption').textContent = caption;
    const lb = document.getElementById('lightbox');
    lb.classList.remove('hidden');
    lb.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeLightbox() {
    const lb = document.getElementById('lightbox');
    lb.classList.add('hidden');
    lb.classList.remove('flex');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });
</script>
@endpush