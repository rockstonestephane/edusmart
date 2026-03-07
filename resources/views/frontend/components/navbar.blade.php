{{--
┌─────────────────────────────────────────────────────────────────────┐
│  EDU SMART SCHOOL V2 — Navbar Component                             │
│  resources/views/frontend/components/navbar.blade.php               │
│  Usage : @include('frontend.components.navbar')                     │
│                                                                     │
│  Variables Blade optionnelles :                                     │
│    $flashInfos       → array de strings pour le ticker              │
│    $schoolName       → nom de l'école                               │
│    $schoolLogo       → path du logo (asset)                         │
│    $espaceParentUrl  → URL espace parent                            │
└─────────────────────────────────────────────────────────────────────┘
--}}

<style>
/* ══════════════════════════════════════════════════
   TICKER BAR — barre dorée
══════════════════════════════════════════════════ */
.ticker-bar {
    background: #f5c842;
    height: 42px;
    display: flex;
    align-items: center;
    overflow: hidden;
    border-bottom: 2px solid #e8b014;
    position: relative;
    z-index: 61;
    flex-shrink: 0;
}
.ticker-label {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 8px;
    height: 100%;
    background: #0d1224;
    color: #f5c842;
    font-family: 'DM Sans', sans-serif;
    font-weight: 700;
    font-size: 0.72rem;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    white-space: nowrap;
    padding: 0 30px 0 20px;
    clip-path: polygon(0 0, calc(100% - 14px) 0, 100% 50%, calc(100% - 14px) 100%, 0 100%);
    user-select: none;
}
.ticker-badge {
    background: #2952f5;
    color: #fff;
    font-size: 0.6rem;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    padding: 2px 8px;
    border-radius: 3px;
    line-height: 1.7;
}
.ticker-viewport {
    flex: 1;
    overflow: hidden;
    height: 100%;
    display: flex;
    align-items: center;
    position: relative;
    mask-image: linear-gradient(to right, transparent 0, black 28px, black calc(100% - 28px), transparent 100%);
    -webkit-mask-image: linear-gradient(to right, transparent 0, black 28px, black calc(100% - 28px), transparent 100%);
}
.ticker-track {
    display: flex;
    align-items: center;
    white-space: nowrap;
    animation: ticker-roll 36s linear infinite;
    will-change: transform;
}
.ticker-track:hover,
.ticker-track.paused { animation-play-state: paused; }
@keyframes ticker-roll {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}
.ticker-item {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 0 36px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.8rem;
    font-weight: 500;
    color: #0d1224;
    cursor: default;
}
.ticker-item::before {
    content: '';
    display: inline-block;
    width: 7px; height: 7px;
    background: #2952f5;
    border-radius: 50%;
    flex-shrink: 0;
}
.ticker-controls {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    gap: 2px;
    padding: 0 8px;
    height: 100%;
    background: rgba(0,0,0,0.1);
    border-left: 1px solid rgba(0,0,0,0.08);
}
.ticker-btn {
    width: 26px; height: 26px;
    display: flex; align-items: center; justify-content: center;
    background: #0d1224;
    color: #f5c842;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
    padding: 0;
    line-height: 1;
}
.ticker-btn:hover { background: #2952f5; transform: scale(1.1); }

/* ══════════════════════════════════════════════════
   MAIN NAVBAR — bleue
══════════════════════════════════════════════════ */
.main-navbar {
    background: #1a3de8;
    position: sticky;
    top: 0;
    z-index: 60;
    transition: background 0.35s, box-shadow 0.35s;
    box-shadow: 0 2px 20px rgba(21,45,212,0.22);
}
.main-navbar.is-scrolled {
    background: #152dd4;
    box-shadow: 0 4px 36px rgba(13,18,36,0.3);
}
.nav-logo-icon {
    width: 42px; height: 42px;
    background: linear-gradient(135deg, #f5c842 0%, #e8b014 100%);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 14px rgba(245,200,66,0.38);
    flex-shrink: 0;
    transition: transform 0.3s ease;
}
a:hover .nav-logo-icon { transform: rotate(-6deg) scale(1.08); }
.nav-logo-img {
    height: 64px;
    width: auto;
    max-width: 180px;
    object-fit: contain;
    flex-shrink: 0;
    transition: transform 0.3s ease, opacity 0.3s ease;
    filter: drop-shadow(0 2px 8px rgba(0,0,0,0.18));
    border-radius: 10px;
}
a:hover .nav-logo-img { transform: scale(1.05); opacity: 0.92; }
.nav-link {
    text-transform: uppercase;
    position: relative;
    font-family: 'DM Sans', sans-serif;
    font-size: 1rem;
    font-weight: 700;
    color: rgba(255,255,255,0.85);
    padding: 7px 13px;
    border-radius: 8px;
    letter-spacing: 0.05em;
    text-decoration: none;
    white-space: nowrap;
    transition: color 0.2s, background 0.2s;
}
.nav-link:hover { color: #fff; background: rgba(255,255,255,0.1); }
.nav-link.is-active { color: #fff; background: rgba(255,255,255,0.12); }
.nav-link.is-active::after {
    content: '';
    position: absolute;
    bottom: 2px; left: 13px; right: 13px;
    height: 2px;
    background: #f5c842;
    border-radius: 2px;
}
.btn-espace {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 16px;
    border-radius: 9px;
    border: 1.5px solid rgba(245,200,66,0.45);
    color: #f5c842;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.8rem;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
    transition: background 0.2s, border-color 0.2s, transform 0.2s;
}
.btn-espace:hover { background: rgba(245,200,66,0.1); border-color: #f5c842; transform: translateY(-2px); }
.btn-preinscription {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 20px;
    border-radius: 10px;
    background: #f5c842;
    color: #0d1224;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.8rem;
    font-weight: 800;
    letter-spacing: 0.03em;
    text-decoration: none;
    white-space: nowrap;
    box-shadow: 0 4px 16px rgba(245,200,66,0.38);
    transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
}
.btn-preinscription:hover {
    background: #ffe066;
    box-shadow: 0 8px 28px rgba(245,200,66,0.48);
    transform: translateY(-2px);
}
.nav-vr {
    width: 1px; height: 22px;
    background: rgba(255,255,255,0.2);
    flex-shrink: 0;
}

/* ── Switcher langue ── */
.lang-switcher {
    display: flex;
    align-items: center;
    gap: 2px;
    background: rgba(255,255,255,0.1);
    border-radius: 8px;
    padding: 3px;
    flex-shrink: 0;
}
.lang-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 5px 10px;
    border-radius: 6px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 0.06em;
    text-decoration: none;
    transition: background 0.2s, color 0.2s;
    color: rgba(255,255,255,0.6);
}
.lang-btn:hover { color: #fff; background: rgba(255,255,255,0.12); }
.lang-btn.is-active { background: #fff; color: #1a3de8; }

/* ── Mobile ── */
.hamburger { outline: none; }
.ham-line {
    display: block;
    width: 22px; height: 2px;
    background: #f5c842;
    border-radius: 2px;
    transform-origin: center;
    transition: transform 0.3s cubic-bezier(.68,-.55,.27,1.55), opacity 0.2s ease;
}
.mobile-menu {
    background: #152dd4;
    border-top: 1px solid rgba(255,255,255,0.06);
}
.m-nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 24px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.88rem;
    font-weight: 600;
    color: rgba(255,255,255,0.82);
    text-decoration: none;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    transition: background 0.2s, color 0.2s, padding-left 0.25s;
}
.m-nav-link:hover, .m-nav-link.is-active {
    background: rgba(255,255,255,0.07);
    color: #f5c842;
    padding-left: 32px;
}
.m-nav-link .m-dot {
    width: 6px; height: 6px;
    background: rgba(245,200,66,0.45);
    border-radius: 50%;
    flex-shrink: 0;
    transition: background 0.2s;
}
.m-nav-link:hover .m-dot,
.m-nav-link.is-active .m-dot { background: #f5c842; }

/* ── Langue mobile ── */
.mobile-lang-bar {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    background: rgba(0,0,0,0.1);
}
.mobile-lang-bar > span {
    font-family: 'DM Sans', sans-serif;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.35);
}
.mobile-lang-btn {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 5px 12px;
    border-radius: 6px;
    font-family: 'DM Sans', sans-serif;
    font-size: 0.75rem;
    font-weight: 800;
    text-decoration: none;
    border: 1px solid rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.55);
    transition: background 0.2s, color 0.2s, border-color 0.2s;
}
.mobile-lang-btn:hover { color: #fff; background: rgba(255,255,255,0.08); }
.mobile-lang-btn.is-active { background: #f5c842; color: #0d1224; border-color: #f5c842; }

.mobile-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding: 16px;
    background: rgba(0,0,0,0.15);
}
.nav-logo-link { margin-right: 2rem; }
</style>

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- 1 ▸ TICKER BAR DORÉE                                              --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
<div class="ticker-bar" id="tickerBar" role="marquee" aria-live="off" aria-label="Informations flash">

    <div class="ticker-label" aria-hidden="true">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#f5c842"
             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
        </svg>
        À la une
        <span class="ticker-badge">Infos</span>
    </div>

    <div class="ticker-viewport" aria-hidden="true">
        <div class="ticker-track" id="tickerTrack">
            @php
            $infos = $flashInfos ?? [
                'Rentrée 2025–2026 : les inscriptions sont ouvertes — déposez votre dossier en ligne dès maintenant',
                'Résultats du concours d\'entrée en 6ème disponibles sur l\'Espace Parent',
                'Portes ouvertes samedi 22 mars 2025 de 9h à 17h — venez découvrir nos installations',
                'Félicitations à nos bacheliers : 100 % de réussite avec 42 % de mentions !',
                'Nouveau laboratoire informatique inauguré — 60 postes disponibles pour nos élèves',
            ];
            $doubled = array_merge($infos, $infos);
            @endphp
            @foreach($doubled as $info)
                <span class="ticker-item">{{ $info }}</span>
            @endforeach
        </div>
    </div>

    <div class="ticker-controls" role="group" aria-label="Navigation infos">
        <button class="ticker-btn" id="tickerPrev" title="Info précédente" aria-label="Info précédente">
            <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
        </button>
        <button class="ticker-btn" id="tickerNext" title="Info suivante" aria-label="Info suivante">
            <svg width="9" height="9" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                 stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"/>
            </svg>
        </button>
    </div>

</div>{{-- /ticker-bar --}}


{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- 2 ▸ NAVBAR PRINCIPALE BLEUE                                        --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
@php
$navLinks = [
    ['label' => __('navigation.accueil'),    'route' => 'home'],
    ['label' => __('navigation.a_propos'),   'route' => 'about'],
    ['label' => __('navigation.formations'), 'route' => 'formations'],
    ['label' => __('navigation.actualites'), 'route' => 'actualites'],
    ['label' => __('navigation.galerie'),    'route' => 'galerie'],
    ['label' => __('navigation.contact'),    'route' => 'contact'],
];
$currentRoute  = Route::currentRouteName();
$currentLocale = app()->getLocale();

$logoTimestamp = '';
if (!empty($schoolLogo)) {
    $logoFullPath  = public_path($schoolLogo);
    $logoTimestamp = file_exists($logoFullPath) ? '?v=' . filemtime($logoFullPath) : '?v=' . time();
}
@endphp

<nav class="main-navbar" id="mainNavbar"
     x-data="{ open: false }"
     role="navigation"
     aria-label="Navigation principale">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-[100px] gap-4">

            {{-- ── Logo ── --}}
            <a href="{{ lroute('home') }}" class="flex items-center gap-3 flex-shrink-0 nav-logo-link"
               aria-label="{{ $schoolName ?? config('school.name', 'EduSmart School') }} — Accueil">
                @if(!empty($schoolLogo))
                    <img src="{{ asset($schoolLogo) }}{{ $logoTimestamp }}"
                         alt="{{ $schoolName ?? config('school.name', 'EduSmart') }}"
                         class="nav-logo-img">
                @else
                    <div class="nav-logo-icon">
                        <svg width="21" height="21" viewBox="0 0 24 24" fill="none"
                             stroke="#0d1224" stroke-width="2.2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                            <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                        </svg>
                    </div>
                @endif
                <div class="leading-tight">
                    <span class="block font-display font-bold text-white text-[15px] leading-none">
                        {{ $schoolName ?? config('school.name', 'EduSmart') }}
                    </span>
                    <span class="block text-[10px] font-body font-semibold tracking-[0.14em] uppercase mt-[3px]"
                          style="color:#f5c842">
                        {{ config('school.slogan', 'School of Excellence') }}
                    </span>
                </div>
            </a>

            {{-- ── Liens desktop ── --}}
            <ul class="hidden lg:flex items-center gap-0.5 flex-1 justify-center" role="menubar">
                @foreach($navLinks as $link)
                <li role="none">
                    <a href="{{ lroute($link['route']) }}"
                       class="nav-link {{ $currentRoute === $link['route'] ? 'is-active' : '' }}"
                       role="menuitem"
                       @if($currentRoute === $link['route']) aria-current="page" @endif>
                        {{ $link['label'] }}
                    </a>
                </li>
                @endforeach
            </ul>

            {{-- ── Actions desktop ── --}}
            <div class="hidden lg:flex items-center gap-3 flex-shrink-0">

                {{-- Switcher langue --}}
                <div class="lang-switcher" role="group" aria-label="Changer de langue">
                <a href="{{ switch_locale_url('fr') }}"
                   class="lang-btn {{ $currentLocale === 'fr' ? 'is-active' : '' }}"
                   hreflang="fr" aria-label="Version française">
                    <img src="https://flagcdn.com/w20/fr.png" width="18" height="13" alt="FR" style="border-radius:2px">
                    FR
                </a>
                <a href="{{ switch_locale_url('en') }}"
                   class="lang-btn {{ $currentLocale === 'en' ? 'is-active' : '' }}"
                   hreflang="en" aria-label="English version">
                    <img src="https://flagcdn.com/w20/gb.png" width="18" height="13" alt="EN" style="border-radius:2px">
                    EN
                </a>
            </div>

                <div class="nav-vr" aria-hidden="true"></div>

                @if(!empty($espaceParentUrl) && $espaceParentUrl !== '#')
                <a href="{{ $espaceParentUrl }}" target="_blank" rel="noopener noreferrer" class="btn-espace">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2.2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    Espace parent
                </a>
                <div class="nav-vr" aria-hidden="true"></div>
                @endif

                <a href="{{ lroute('preinscription') }}" class="btn-preinscription">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
                {{ __('navigation.preinscription') }}
            </a>

            </div>

            {{-- ── Hamburger mobile ── --}}
            <button class="hamburger lg:hidden w-10 h-10 flex flex-col items-center justify-center gap-[6px]
                           rounded-lg hover:bg-white/10 transition-colors"
                    @click="open = !open"
                    :aria-expanded="open.toString()"
                    aria-controls="mobileMenu"
                    aria-label="Ouvrir le menu">
                <span class="ham-line" :class="open ? 'rotate-45 translate-y-2' : ''"></span>
                <span class="ham-line" :class="open ? 'opacity-0 scale-x-0' : ''"></span>
                <span class="ham-line" :class="open ? '-rotate-45 -translate-y-2' : ''"></span>
            </button>

        </div>
    </div>

    {{-- ── Menu mobile ── --}}
    <div class="mobile-menu lg:hidden"
         id="mobileMenu"
         x-show="open"
         x-transition:enter="transition ease-out duration-240"
         x-transition:enter-start="opacity-0 -translate-y-3"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-180"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-3"
         role="menu">

        @foreach($navLinks as $link)
        <a href="{{ lroute($link['route']) }}"
           class="m-nav-link {{ $currentRoute === $link['route'] ? 'is-active' : '' }}"
           @click="open = false"
           role="menuitem"
           @if($currentRoute === $link['route']) aria-current="page" @endif>
            <span class="m-dot" aria-hidden="true"></span>
            {{ $link['label'] }}
        </a>
        @endforeach

        {{-- Switcher langue mobile --}}
        <div class="mobile-lang-bar">
    <span>Langue :</span>
    <a href="{{ switch_locale_url('fr') }}"
       class="mobile-lang-btn {{ $currentLocale === 'fr' ? 'is-active' : '' }}"
       hreflang="fr">
        <img src="https://flagcdn.com/w20/fr.png" width="18" height="13" alt="FR" style="border-radius:2px">
        FR
    </a>
    <a href="{{ switch_locale_url('en') }}"
       class="mobile-lang-btn {{ $currentLocale === 'en' ? 'is-active' : '' }}"
       hreflang="en">
        <img src="https://flagcdn.com/w20/gb.png" width="18" height="13" alt="EN" style="border-radius:2px">
        EN
    </a>
    </div>

        <div class="mobile-actions">
            @if(!empty($espaceParentUrl) && $espaceParentUrl !== '#')
            <a href="{{ $espaceParentUrl }}" target="_blank" rel="noopener noreferrer"
               class="btn-espace justify-center">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.2"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                Espace parent
            </a>
            @endif
            <a href="{{ lroute('preinscription') }}"
           class="btn-preinscription justify-center"
           @click="open = false">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2.5"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            {{ __('navigation.preinscription') }}
            </a>
        </div>

    </div>{{-- /mobile-menu --}}

</nav>

{{-- ═══════════════════════════════════════════════════════════════════ --}}
{{-- SCRIPT TICKER                                                      --}}
{{-- ═══════════════════════════════════════════════════════════════════ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const navbar = document.getElementById('mainNavbar');
    const onScroll = () => navbar.classList.toggle('is-scrolled', window.scrollY > 20);
    window.addEventListener('scroll', onScroll, { passive: true });

    const track   = document.getElementById('tickerTrack');
    const prevBtn = document.getElementById('tickerPrev');
    const nextBtn = document.getElementById('tickerNext');
    if (!track || !prevBtn || !nextBtn) return;

    const allItems  = Array.from(track.querySelectorAll('.ticker-item'));
    const halfCount = allItems.length / 2;
    let currentIdx  = 0;
    let resumeTimer = null;

    function offsetFor(idx) {
        let px = 0;
        for (let i = 0; i < idx; i++) px += allItems[i].offsetWidth;
        return px;
    }

    function jumpTo(idx) {
        currentIdx = ((idx % halfCount) + halfCount) % halfCount;
        track.classList.add('paused');
        track.style.animationPlayState = 'paused';
        track.style.transform = `translateX(-${offsetFor(currentIdx)}px)`;
        track.style.transition = 'transform 0.4s cubic-bezier(.4,0,.2,1)';
        clearTimeout(resumeTimer);
        resumeTimer = setTimeout(resumeAnim, 5000);
    }

    function resumeAnim() {
        track.style.transition = 'none';
        track.style.transform  = '';
        track.classList.remove('paused');
        track.style.animationPlayState = 'running';
        void track.offsetWidth;
        track.style.animation = 'ticker-roll 36s linear infinite';
    }

    prevBtn.addEventListener('click', () => jumpTo(currentIdx - 1));
    nextBtn.addEventListener('click', () => jumpTo(currentIdx + 1));
});
</script>