@extends('frontend.layout.frontend')

@section('title', config('school.name') . ' — Contact')

@section('content')

{{-- HERO --}}
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
            ✉️ Contactez-nous
        </span>
        <h1 class="font-display text-5xl md:text-6xl font-bold text-white mt-4 mb-6">
            Nous <span style="background:linear-gradient(135deg,#f5c842,#e8b014);
                              -webkit-background-clip:text;-webkit-text-fill-color:transparent;
                              background-clip:text;">contacter</span>
        </h1>
        <p class="text-white/70 text-lg max-w-2xl mx-auto">
            Notre équipe est disponible pour répondre à toutes vos questions.
        </p>
    </div>
</section>

{{-- INFOS RAPIDES --}}
<section class="py-12 bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach([
                ['📍', 'Adresse',   env('SCHOOL_ADDRESS', config('school.address')),    null],
                ['📞', 'Téléphone', env('SCHOOL_PHONE',   config('school.phone')),       'tel:'.env('SCHOOL_PHONE', config('school.phone'))],
                ['✉️', 'Email',     env('SCHOOL_EMAIL',   config('school.email')),       'mailto:'.env('SCHOOL_EMAIL', config('school.email'))],
                ['🕐', 'Horaires',  env('SCHOOL_HOURS',   config('school.hours.label')), null],
            ] as [$icon, $label, $value, $href])
            @if($value)
            <div class="flex items-start gap-4 p-5 bg-gray-50 rounded-2xl" data-aos="fade-up">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl flex-shrink-0"
                     style="background:linear-gradient(135deg,#f0f4ff,#dce6ff)">{{ $icon }}</div>
                <div>
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">{{ $label }}</div>
                    @if($href)
                    <a href="{{ $href }}" class="text-sm font-medium text-gray-800 hover:text-blue-600 transition-colors">
                        {{ $value }}
                    </a>
                    @else
                    <p class="text-sm font-medium text-gray-800">{{ $value }}</p>
                    @endif
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>

{{-- FORMULAIRE + CARTE --}}
<section class="py-24" style="background:#f7f8fc">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            {{-- ── Formulaire ── --}}
            <div data-aos="fade-right">

                {{-- Ancre pour le scroll --}}
                <div id="formulaire"></div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                    <h2 class="font-display text-2xl font-bold text-gray-800 mb-2">Envoyez-nous un message</h2>
                    <p class="text-gray-400 text-sm mb-6">Nous vous répondrons dans les plus brefs délais.</p>

                    <form method="POST" action="{{ lroute('contact.send') }}" class="space-y-5">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Votre nom <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nom" value="{{ old('nom') }}"
                                       placeholder="Jean MBARGA"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                              outline-none transition-all focus:border-blue-500 focus:ring-2
                                              focus:ring-blue-100 @error('nom') border-red-400 @enderror"
                                       required>
                                @error('nom')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Votre email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                       placeholder="jean@email.com"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                              outline-none transition-all focus:border-blue-500 focus:ring-2
                                              focus:ring-blue-100 @error('email') border-red-400 @enderror"
                                       required>
                                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Sujet <span class="text-red-500">*</span>
                            </label>
                            <select name="sujet"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                           outline-none transition-all bg-white focus:border-blue-500
                                           focus:ring-2 focus:ring-blue-100">
                                <option value="">-- Choisir un sujet --</option>
                                @foreach([
                                    "Demande d'information générale",
                                    'Renseignement sur les inscriptions',
                                    'Renseignement sur les formations',
                                    'Demande de rendez-vous',
                                    'Partenariat',
                                    'Autre',
                                ] as $sujet)
                                <option value="{{ $sujet }}" {{ old('sujet') == $sujet ? 'selected' : '' }}>
                                    {{ $sujet }}
                                </option>
                                @endforeach
                            </select>
                            @error('sujet')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Message <span class="text-red-500">*</span>
                            </label>
                            <textarea name="message" rows="5" placeholder="Votre message..."
                                      class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                             outline-none transition-all resize-vertical focus:border-blue-500
                                             focus:ring-2 focus:ring-blue-100
                                             @error('message') border-red-400 @enderror"
                                      required>{{ old('message') }}</textarea>
                            @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <button type="submit"
                                class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-bold
                                       text-sm text-white hover:-translate-y-1 transition-all duration-300
                                       w-full justify-center"
                                style="background:linear-gradient(135deg,#2952f5,#152dd4);
                                       box-shadow:0 8px 24px rgba(41,82,245,0.3)">
                            ✉️ Envoyer le message
                        </button>
                    </form>

                    {{-- Message succès sous le formulaire --}}
                    @if(session('success'))
                    <div id="success-message"
                         class="mt-5 p-4 rounded-2xl flex items-center gap-3"
                         style="background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d">
                        ✅ {{ session('success') }}
                    </div>
                    @endif

                </div>

                {{-- Réseaux sociaux --}}
                <div class="mt-5 bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                    <h3 class="font-semibold text-gray-700 mb-3 text-sm">Suivez-nous sur les réseaux</h3>
                    <div class="flex gap-3 flex-wrap">

                        @php $whatsapp = env('SCHOOL_WHATSAPP', config('school.social.whatsapp')); @endphp
                        @if($whatsapp && $whatsapp !== '#')
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $whatsapp) }}"
                           target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold
                                  border transition-all hover:-translate-y-0.5"
                           style="background:#f0fdf4;color:#16a34a;border-color:#bbf7d0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#25D366">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            WhatsApp
                        </a>
                        @endif

                        @php $facebook = env('SCHOOL_FACEBOOK', config('school.social.facebook')); @endphp
                        @if($facebook && $facebook !== '#')
                        <a href="{{ $facebook }}" target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold
                                  border transition-all hover:-translate-y-0.5"
                           style="background:#eff6ff;color:#1d4ed8;border-color:#bfdbfe">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#1877F2">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </a>
                        @endif

                        @php $instagram = env('SCHOOL_INSTAGRAM', config('school.social.instagram')); @endphp
                        @if($instagram && $instagram !== '#')
                        <a href="{{ $instagram }}" target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold
                                  border transition-all hover:-translate-y-0.5"
                           style="background:#fdf2f8;color:#be185d;border-color:#fbcfe8">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24">
                                <defs>
                                    <linearGradient id="igGrad" x1="0%" y1="100%" x2="100%" y2="0%">
                                        <stop offset="0%" style="stop-color:#f09433"/>
                                        <stop offset="25%" style="stop-color:#e6683c"/>
                                        <stop offset="50%" style="stop-color:#dc2743"/>
                                        <stop offset="75%" style="stop-color:#cc2366"/>
                                        <stop offset="100%" style="stop-color:#bc1888"/>
                                    </linearGradient>
                                </defs>
                                <path fill="url(#igGrad)" d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                            </svg>
                            Instagram
                        </a>
                        @endif

                        @php $tiktok = env('SCHOOL_TIKTOK', config('school.social.tiktok')); @endphp
                        @if($tiktok && $tiktok !== '#')
                        <a href="{{ $tiktok }}" target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold
                                  border transition-all hover:-translate-y-0.5"
                           style="background:#f9f9f9;color:#111111;border-color:#e5e7eb">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#000000">
                                <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1V9.01a6.33 6.33 0 00-.79-.05 6.34 6.34 0 00-6.34 6.34 6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.33-6.34V8.69a8.18 8.18 0 004.78 1.52V6.75a4.85 4.85 0 01-1.01-.06z"/>
                            </svg>
                            TikTok
                        </a>
                        @endif

                        @php $youtube = env('SCHOOL_YOUTUBE', config('school.social.youtube')); @endphp
                        @if($youtube && $youtube !== '#')
                        <a href="{{ $youtube }}" target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold
                                  border transition-all hover:-translate-y-0.5"
                           style="background:#fff5f5;color:#dc2626;border-color:#fecaca">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#FF0000">
                                <path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                            YouTube
                        </a>
                        @endif

                        @php $linkedin = env('SCHOOL_LINKEDIN', config('school.social.linkedin')); @endphp
                        @if($linkedin && $linkedin !== '#')
                        <a href="{{ $linkedin }}" target="_blank" rel="noopener"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold
                                  border transition-all hover:-translate-y-0.5"
                           style="background:#eff6ff;color:#0369a1;border-color:#bae6fd">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#0A66C2">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                            LinkedIn
                        </a>
                        @endif

                    </div>
                </div>
            </div>

            {{-- ── Carte Google Maps ── --}}
            <div data-aos="fade-left">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden h-full"
                     style="min-height:500px">
                    @php $mapsUrl = env('SCHOOL_MAPS_URL', ''); @endphp
                    @if($mapsUrl)
                    <iframe src="{{ $mapsUrl }}" width="100%" height="100%"
                            style="border:0;min-height:500px" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @else
                    <div class="flex flex-col items-center justify-center h-full p-12 text-center"
                         style="min-height:500px;background:linear-gradient(135deg,#f0f4ff,#dce6ff)">
                        <div class="text-6xl mb-4">🗺️</div>
                        <h3 class="font-display text-xl font-bold text-gray-700 mb-2">Carte non configurée</h3>
                        <p class="text-gray-500 text-sm mb-6 max-w-xs">
                            Ajoutez l'URL Google Maps dans les paramètres de l'école.
                        </p>
                        <div class="mt-4 p-4 bg-white rounded-xl border border-gray-200 w-full">
                            <div class="flex items-start gap-3">
                                <span class="text-2xl">📍</span>
                                <div class="text-left">
                                    <p class="text-sm font-medium text-gray-800">
                                        {{ env('SCHOOL_ADDRESS', config('school.address')) }}
                                    </p>
                                    @if(env('SCHOOL_PHONE', config('school.phone')))
                                    <p class="text-sm text-blue-600 mt-1">
                                        📞 {{ env('SCHOOL_PHONE', config('school.phone')) }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

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

@endsection