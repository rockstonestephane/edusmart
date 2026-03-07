{{--
╔══════════════════════════════════════════════════════════════════════╗
║  EDU SMART SCHOOL V2                                                 ║
║  Layout principal : resources/views/frontend/layouts/frontend.blade.php ║
║                                                                      ║
║  Pages enfants étendent ce layout :                                  ║
║    @extends('frontend.layouts.frontend')                             ║
║    @section('content') … @endsection                                 ║
╚══════════════════════════════════════════════════════════════════════╝
--}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $meta_description ?? config('school.description', 'Établissement scolaire d\'excellence') }}">
    <meta name="robots" content="index, follow">
    <meta property="og:title" content="{{ config('school.name') }}">
<meta property="og:description" content="{{ config('school.description') }}">
<meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
    <title>@yield('title', config('school.name', 'EduSmart School'))</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Swiper CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    {{-- AOS CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.4/dist/aos.css">

    {{-- Tailwind CDN (remplacer par `npm run build` en production) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        display: ['Playfair Display', 'serif'],
                        body:    ['DM Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50:  '#f0f4ff',
                            100: '#dce6ff',
                            200: '#b9ccff',
                            300: '#89a8ff',
                            400: '#547bff',
                            500: '#2952f5',
                            600: '#1a3de8',
                            700: '#152dd4',
                            800: '#1726ab',
                            900: '#192686',
                        },
                        gold: {
                            400: '#f5c842',
                            500: '#e8b014',
                            600: '#c9920a',
                        },
                        dark: '#0d1224',
                    },
                    keyframes: {
                        fadeUp: {
                            '0%':   { opacity: 0, transform: 'translateY(30px)' },
                            '100%': { opacity: 1, transform: 'translateY(0)' },
                        },
                        float: {
                            '0%,100%': { transform: 'translateY(0)' },
                            '50%':     { transform: 'translateY(-14px)' },
                        },
                    },
                    animation: {
                        'fade-up': 'fadeUp 0.8s ease forwards',
                        'float':   'float 6s ease-in-out infinite',
                    },
                }
            }
        }
    </script>

    <style>
        /* ── Reset & base ─────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; }
        html  { scroll-behavior: smooth; }
        body  { font-family: 'DM Sans', sans-serif; color: #0d1224; background: #fff; overflow-x: hidden; }
        h1,h2,h3,h4,h5 { font-family: 'Playfair Display', serif; }

        /* ── Hero Swiper ──────────────────────────────────── */
        .hero-swiper { width: 100%; height: 100vh; min-height: 600px; }
        .hero-swiper .swiper-slide {
            position: relative; display: flex;
            align-items: center; justify-content: center;
        }
        .hero-swiper .slide-bg {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
            transform: scale(1.06); transition: transform 6s ease;
        }
        .swiper-slide-active .slide-bg { transform: scale(1); }
        .hero-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(13,18,36,.78) 0%, rgba(25,38,134,.55) 60%, transparent 100%);
        }
        .hero-content { position: relative; z-index: 2; }

        /* ── Swiper paginaton & nav ───────────────────────── */
        .swiper-pagination-bullet          { background: rgba(255,255,255,.5) !important; opacity:1 !important; width:8px !important; height:8px !important; }
        .swiper-pagination-bullet-active   { background: #f5c842 !important; width:28px !important; border-radius:4px !important; }
        .swiper-button-next,
        .swiper-button-prev                { color:#fff !important; background:rgba(255,255,255,.12); width:50px !important; height:50px !important; border-radius:50%; backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,.2); transition:background .3s; }
        .swiper-button-next:hover,
        .swiper-button-prev:hover          { background:rgba(41,82,245,.6) !important; }
        .swiper-button-next::after,
        .swiper-button-prev::after         { font-size:16px !important; font-weight:700; }

        /* ── Utilitaires réutilisables ───────────────────── */
        .section-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg,#f0f4ff,#dce6ff);
            color: #1a3de8; font-size: .75rem; font-weight: 600;
            letter-spacing: .12em; text-transform: uppercase;
            padding: 6px 16px; border-radius: 100px;
            border: 1px solid rgba(41,82,245,.15);
        }
        .gradient-text {
            background: linear-gradient(135deg,#2952f5,#e8b014);
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }
        .card-hover { transition: transform .35s cubic-bezier(.22,.68,0,1.2), box-shadow .35s ease; }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 24px 48px rgba(41,82,245,.14); }
        .blob {
            position: absolute; border-radius: 60% 40% 70% 30%/50% 60% 40% 50%;
            filter: blur(56px); opacity: .18; pointer-events: none;
        }

        /* ── Footer ──────────────────────────────────────── */
        .footer-bg { background: linear-gradient(160deg,#0d1224 0%,#192686 60%,#0d1224 100%); }

        /* ── Préloader ────────────────────────────────────── */
        #preloader {
            position: fixed; inset: 0; z-index: 9999;
            background: #0d1224;
            display: flex; align-items: center; justify-content: center;
            transition: opacity .6s ease, visibility .6s ease;
        }
        #preloader.hidden { opacity: 0; visibility: hidden; }
        .loader-ring {
            width: 52px; height: 52px;
            border: 3px solid rgba(255,255,255,.1);
            border-top-color: #f5c842; border-radius: 50%;
            animation: spin .9s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Back to top ──────────────────────────────────── */
        #back-top {
            position: fixed; bottom: 28px; right: 28px; z-index: 900;
            width: 46px; height: 46px;
            background: linear-gradient(135deg,#2952f5,#192686);
            color: #fff; border-radius: 50%; border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 24px rgba(41,82,245,.4);
            opacity: 0; pointer-events: none;
            transition: opacity .3s, transform .3s;
            transform: translateY(12px);
        }
        #back-top.visible { opacity: 1; pointer-events: all; transform: translateY(0); }

        /* ── WhatsApp flottant ────────────────────────────────── */
#whatsapp-btn {
    position: fixed; bottom: 84px; right: 28px; z-index: 900;
    width: 46px; height: 46px;
    background: #25d366;
    color: #fff; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 8px 24px rgba(37,211,102,.4);
    transition: transform .3s, box-shadow .3s;
}
#whatsapp-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 32px rgba(37,211,102,.5);
}


/* ── FORCE footer grid ── */
footer.edu-footer .footer-grid {
    display: grid !important;
    grid-template-columns: 1.4fr 1fr 1fr 1.3fr !important;
    gap: 48px !important;
}
footer.edu-footer .footer-grid > div {
    min-width: 0 !important;
    width: auto !important;
    display: block !important;
}
@media (max-width: 1024px) {
    footer.edu-footer .footer-grid {
        grid-template-columns: 1fr 1fr !important;
    }
}
@media (max-width: 640px) {
    footer.edu-footer .footer-grid {
        grid-template-columns: 1fr !important;
    }
}
    </style>

    {{-- Styles injectés par les pages enfants --}}
    @stack('styles')
</head>

<body>

{{-- ════════════════════════════════════════════════════ --}}
{{-- PRÉLOADER                                           --}}
{{-- ════════════════════════════════════════════════════ --}}
<div id="preloader" role="status" aria-label="Chargement">
    <div class="text-center">
        <div class="loader-ring mx-auto mb-4"></div>
        <p class="text-white/40 text-xs font-body tracking-widest uppercase">Chargement…</p>
    </div>
</div>

{{-- ════════════════════════════════════════════════════ --}}
{{-- NAVBAR — composant indépendant                      --}}
{{-- ticker doré + navbar bleue sticky                   --}}
{{-- ════════════════════════════════════════════════════ --}}
@include('frontend.components.navbar')

{{-- ════════════════════════════════════════════════════ --}}
{{-- CONTENU PRINCIPAL                                   --}}
{{-- Chaque page enfant remplit @section('content')      --}}
{{-- ════════════════════════════════════════════════════ --}}
<main id="main-content">
    @yield('content')
</main>

{{-- ════════════════════════════════════════════════════ --}}
{{-- FOOTER — composant indépendant                      --}}
{{-- resources/views/frontend/components/footer.blade.php --}}
{{-- ════════════════════════════════════════════════════ --}}
@include('frontend.components.footer')


{{-- ════════════════════════════════════════════════════ --}}
{{-- BOUTON WHATSAPP FLOTTANT                            --}}
{{-- ════════════════════════════════════════════════════ --}}
<a id="whatsapp-btn"
   href="https://wa.me/237697000846"
   target="_blank"
   rel="noopener noreferrer"
   title="Contactez-nous sur WhatsApp"
   aria-label="Contacter EduSmart sur WhatsApp">
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.117.549 4.107 1.509 5.843L.057 23.428a.75.75 0 00.921.921l5.585-1.452A11.942 11.942 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.75a9.725 9.725 0 01-4.964-1.359l-.355-.212-3.686.958.977-3.578-.232-.368A9.725 9.725 0 012.25 12C2.25 6.615 6.615 2.25 12 2.25S21.75 6.615 21.75 12 17.385 21.75 12 21.75z"/>
    </svg>
</a>

{{-- ════════════════════════════════════════════════════ --}}
{{-- BOUTON RETOUR EN HAUT                               --}}
{{-- ════════════════════════════════════════════════════ --}}
<button id="back-top"
        onclick="window.scrollTo({top:0,behavior:'smooth'})"
        title="Retour en haut"
        aria-label="Retour en haut de page">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
    </svg>
</button>

{{-- ════════════════════════════════════════════════════ --}}
{{-- SCRIPTS                                             --}}
{{-- ════════════════════════════════════════════════════ --}}

{{-- Alpine.js (doit être chargé AVANT les composants x-data) --}}
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
{{-- Swiper --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
{{-- AOS --}}
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Préloader ─────────────────────────────────────
    const preloader = document.getElementById('preloader');
    window.addEventListener('load', function () {
        setTimeout(function () { preloader.classList.add('hidden'); }, 350);
    });

    // ── AOS ───────────────────────────────────────────
    AOS.init({ duration: 800, easing: 'ease-out-cubic', once: true, offset: 60 });

    // ── Hero Swiper ───────────────────────────────────
    if (document.querySelector('#hero')) {
        new Swiper('#hero', {
            loop: true,
            speed: 1000,
            autoplay: { delay: 6000, disableOnInteraction: false, pauseOnMouseEnter: true },
            effect: 'fade',
            fadeEffect: { crossFade: true },
            pagination: { el: '#hero .swiper-pagination', clickable: true },
            navigation: {
                nextEl: '#hero .swiper-button-next',
                prevEl: '#hero .swiper-button-prev',
            },
        });
    }

    // ── Gallery Swiper ────────────────────────────────
if (document.querySelector('.gallery-swiper')) {
    new Swiper('.gallery-swiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: true,
        autoHeight: false,
        autoplay: { delay: 3500, disableOnInteraction: false },
        pagination: { el: '.gallery-swiper .swiper-pagination', clickable: true },
        breakpoints: {
            640:  { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        },
    });
}

    // ── Testimonials Swiper ───────────────────────────
    if (document.querySelector('.testimonials-swiper')) {
        new Swiper('.testimonials-swiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.testimonials-swiper .swiper-pagination', clickable: true },
            breakpoints: {
                768:  { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
            },
        });
    }

    // ── Back to top ───────────────────────────────────
    const backTop = document.getElementById('back-top');
    window.addEventListener('scroll', function () {
        backTop.classList.toggle('visible', window.scrollY > 400);
    }, { passive: true });

});
</script>

{{-- Scripts injectés par les pages enfants --}}
@stack('scripts')

</body>
</html>