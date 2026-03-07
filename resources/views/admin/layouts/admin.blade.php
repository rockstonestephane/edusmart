<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') — Admin {{ config('school.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'DM Sans', sans-serif; background: #f0f2f8; }
        h1,h2,h3,h4 { font-family: 'Playfair Display', serif; }

        /* ── Sidebar ── */
        .sidebar {
            width: 260px;
            background: linear-gradient(160deg, #0d1224 0%, #192686 100%);
            min-height: 100vh;
            position: fixed;
            top: 0; left: 0;
            z-index: 50;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
        }
        .sidebar-logo {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            flex-shrink: 0;
        }
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 12px 10px;
        }
        .sidebar-nav::-webkit-scrollbar { width: 4px; }
        .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 2px; }

        .nav-section-label {
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.25);
            padding: 10px 10px 4px;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 7px 10px;
            border-radius: 9px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 1px;
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }
        .nav-item.active {
            background: rgba(41,82,245,0.35);
            color: #fff;
            border: 1px solid rgba(41,82,245,0.4);
        }
        .nav-item .nav-icon {
            width: 28px; height: 28px;
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.9rem;
            flex-shrink: 0;
            background: rgba(255,255,255,0.06);
        }
        .nav-item.active .nav-icon {
            background: rgba(41,82,245,0.4);
        }
        .nav-badge {
            margin-left: auto;
            background: #ef4444;
            color: #fff;
            font-size: 0.62rem;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 100px;
            min-width: 18px;
            text-align: center;
        }

        /* ── Sous-menu collapsible ── */
        .nav-group-btn {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 7px 10px;
            border-radius: 9px;
            color: rgba(255,255,255,0.6);
            font-size: 0.82rem;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 1px;
            width: 100%;
            text-align: left;
            background: none;
            border: none;
            cursor: pointer;
        }
        .nav-group-btn:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .nav-group-btn.open  { color: #fff; }
        .nav-sub-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 6px 10px 6px 20px;
            border-radius: 8px;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 0.78rem;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 1px;
        }
        .nav-sub-item:hover  { background: rgba(255,255,255,0.06); color: #fff; }
        .nav-sub-item.active { background: rgba(41,82,245,0.25); color: #fff; }
        .nav-sub-dot {
            width: 5px; height: 5px;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            flex-shrink: 0;
        }
        .nav-sub-item.active .nav-sub-dot { background: #f5c842; }
        .nav-chevron {
            margin-left: auto;
            transition: transform 0.2s;
            opacity: 0.4;
        }
        .nav-chevron.rotated { transform: rotate(180deg); }

        /* ── Topbar ── */
        .topbar {
            height: 64px;
            background: #fff;
            border-bottom: 1px solid #e8eaf0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        /* ── Main content ── */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .page-content {
            flex: 1;
            padding: 28px;
        }

        /* ── Cards stats ── */
        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px 24px;
            border: 1px solid #e8eaf0;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(41,82,245,0.1);
        }

        /* ── Table ── */
        .admin-table { width: 100%; border-collapse: collapse; }
        .admin-table th {
            background: #f7f8fc;
            padding: 11px 16px;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #6b7280;
            border-bottom: 1px solid #e8eaf0;
        }
        .admin-table td {
            padding: 13px 16px;
            font-size: 0.85rem;
            color: #374151;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }
        .admin-table tr:hover td { background: #fafbff; }

        /* ── Badges statut ── */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 100px;
            font-size: 0.72rem; font-weight: 600;
        }
        .badge-green  { background: #dcfce7; color: #16a34a; }
        .badge-red    { background: #fee2e2; color: #dc2626; }
        .badge-yellow { background: #fef9c3; color: #ca8a04; }
        .badge-blue   { background: #dbeafe; color: #2563eb; }
        .badge-gray   { background: #f3f4f6; color: #6b7280; }

        /* ── Boutons ── */
        .btn-primary {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 18px; border-radius: 10px;
            background: linear-gradient(135deg, #2952f5, #1a3de8);
            color: #fff; font-size: 0.83rem; font-weight: 700;
            text-decoration: none; border: none; cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(41,82,245,0.35); }
        .btn-secondary {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 18px; border-radius: 10px;
            background: #f3f4f6; color: #374151;
            font-size: 0.83rem; font-weight: 600;
            text-decoration: none; border: none; cursor: pointer;
            transition: background 0.2s;
        }
        .btn-secondary:hover { background: #e5e7eb; }
        .btn-danger {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 7px 14px; border-radius: 8px;
            background: #fee2e2; color: #dc2626;
            font-size: 0.8rem; font-weight: 600;
            border: none; cursor: pointer;
            transition: background 0.2s;
        }
        .btn-danger:hover { background: #fecaca; }
        .btn-edit {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 7px 14px; border-radius: 8px;
            background: #eff6ff; color: #2563eb;
            font-size: 0.8rem; font-weight: 600;
            text-decoration: none;
            transition: background 0.2s;
        }
        .btn-edit:hover { background: #dbeafe; }
        .btn-outline {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 9px 18px; border-radius: 10px;
            background: #fff; color: #374151;
            font-size: 0.83rem; font-weight: 600;
            text-decoration: none;
            border: 1px solid #e5e7eb;
            transition: border-color 0.2s, background 0.2s;
        }
        .btn-outline:hover { border-color: #2952f5; color: #2952f5; }

        /* ── Form ── */
        .form-label { display: block; font-size: 0.8rem; font-weight: 600; color: #374151; margin-bottom: 6px; }
        .form-input {
            width: 100%; padding: 10px 14px;
            border: 1px solid #e5e7eb; border-radius: 10px;
            font-size: 0.85rem; color: #111827;
            font-family: 'DM Sans', sans-serif;
            transition: border-color 0.2s, box-shadow 0.2s; outline: none;
        }
        .form-input:focus { border-color: #2952f5; box-shadow: 0 0 0 3px rgba(41,82,245,0.1); }
        .form-textarea {
            width: 100%; padding: 10px 14px;
            border: 1px solid #e5e7eb; border-radius: 10px;
            font-size: 0.85rem; color: #111827;
            font-family: 'DM Sans', sans-serif;
            resize: vertical; min-height: 100px;
            transition: border-color 0.2s, box-shadow 0.2s; outline: none;
        }
        .form-textarea:focus { border-color: #2952f5; box-shadow: 0 0 0 3px rgba(41,82,245,0.1); }
        .form-select {
            width: 100%; padding: 10px 14px;
            border: 1px solid #e5e7eb; border-radius: 10px;
            font-size: 0.85rem; color: #111827;
            font-family: 'DM Sans', sans-serif;
            background: #fff; outline: none; transition: border-color 0.2s;
        }
        .form-select:focus { border-color: #2952f5; }

        /* ── Upload zone ── */
        .upload-zone {
            border: 2px dashed #e5e7eb; border-radius: 12px;
            padding: 32px; text-align: center; cursor: pointer;
            transition: border-color 0.2s, background 0.2s;
        }
        .upload-zone:hover { border-color: #2952f5; background: #f0f4ff; }

        /* ── Alert ── */
        .alert-success {
            background: #f0fdf4; border: 1px solid #bbf7d0;
            color: #15803d; padding: 12px 16px; border-radius: 10px;
            font-size: 0.85rem; font-weight: 500;
        }
        .alert-error {
            background: #fef2f2; border: 1px solid #fecaca;
            color: #dc2626; padding: 12px 16px; border-radius: 10px;
            font-size: 0.85rem; font-weight: 500;
        }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-260px); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>

<body x-data="{ sidebarOpen: false }">

{{-- Overlay mobile --}}
<div class="fixed inset-0 bg-black/50 z-40 lg:hidden"
     x-show="sidebarOpen"
     @click="sidebarOpen = false"
     x-transition:enter="transition-opacity duration-200"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     style="display:none">
</div>

{{-- ═══════════════════════════════════
     SIDEBAR
═══════════════════════════════════ --}}
<aside class="sidebar" :class="{ 'open': sidebarOpen }">

    {{-- Logo --}}
    <div class="sidebar-logo">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                 style="background:linear-gradient(135deg,#f5c842,#e8b014)">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="#0d1224" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 10v6M2 10l10-5 10 5-10 5z"/>
                    <path d="M6 12v5c3 3 9 3 12 0v-5"/>
                </svg>
            </div>
            <div>
                <div class="text-white font-bold text-sm leading-tight">{{ config('school.name', 'EduSmart') }}</div>
                <div class="text-xs font-semibold tracking-widest uppercase" style="color:#f5c842;font-size:0.6rem">
                    Administration
                </div>
            </div>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav"
         x-data="{
            openContenu: {{ request()->routeIs('admin.hero-slides.*','admin.actualites.*','admin.formations.*','admin.galerie.*','admin.temoignages.*') ? 'true' : 'false' }},
            openAccueil: {{ request()->routeIs('admin.statistiques.*','admin.rentree-scolaire.*') ? 'true' : 'false' }},
            openPages: {{ request()->routeIs('admin.page-heroes.*','admin.about.*','admin.valeurs.*','admin.equipe.*','admin.mot-directeur.*') ? 'true' : 'false' }}
         }">

        {{-- ── Principal ── --}}
        <div class="nav-section-label">Principal</div>

        <a href="{{ route('admin.dashboard') }}"
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon">📊</span>
            Dashboard
        </a>

        {{-- ── Contenu du site (collapsible) ── --}}
        <div class="nav-section-label mt-1">Contenu du site</div>

        <button class="nav-group-btn" :class="{ 'open': openContenu }"
                @click="openContenu = !openContenu">
            <span class="nav-icon">📁</span>
            Contenu
            <svg class="nav-chevron" :class="{ 'rotated': openContenu }"
                 width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="openContenu" x-collapse style="display:none">
            <a href="{{ route('admin.hero-slides.index') }}"
               class="nav-sub-item {{ request()->routeIs('admin.hero-slides.*') ? 'active' : '' }}">
                <span class="nav-sub-dot"></span> Hero Slides
            </a>
            <a href="{{ route('admin.actualites.index') }}"
               class="nav-sub-item {{ request()->routeIs('admin.actualites.*') ? 'active' : '' }}">
                <span class="nav-sub-dot"></span> Actualités
            </a>
            <a href="{{ route('admin.formations.index') }}"
               class="nav-sub-item {{ request()->routeIs('admin.formations.*') ? 'active' : '' }}">
                <span class="nav-sub-dot"></span> Formations
            </a>
            <a href="{{ route('admin.galerie.index') }}"
               class="nav-sub-item {{ request()->routeIs('admin.galerie.*') ? 'active' : '' }}">
                <span class="nav-sub-dot"></span> Galerie
            </a>
            <a href="{{ route('admin.temoignages.index') }}"
               class="nav-sub-item {{ request()->routeIs('admin.temoignages.*') ? 'active' : '' }}">
                <span class="nav-sub-dot"></span> Témoignages
            </a>
        </div>

        {{-- ── Page d'accueil (collapsible) ── --}}
        <button class="nav-group-btn mt-1" :class="{ 'open': openAccueil }"
                @click="openAccueil = !openAccueil">
            <span class="nav-icon">🏠</span>
            Page d'accueil
            <svg class="nav-chevron" :class="{ 'rotated': openAccueil }"
                 width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="openAccueil" x-collapse style="display:none">
            <a href="{{ route('admin.statistiques.index') }}"
               class="nav-sub-item {{ request()->routeIs('admin.statistiques.*') ? 'active' : '' }}">
                <span class="nav-sub-dot"></span> Statistiques
            </a>
            <a href="{{ route('admin.rentree-scolaire.index') }}"
               class="nav-sub-item {{ request()->routeIs('admin.rentree-scolaire.*') ? 'active' : '' }}">
                <span class="nav-sub-dot"></span> Rentrée scolaire
            </a>
        </div>

        {{-- ── Pages du site (collapsible) ── --}}
        <button class="nav-group-btn mt-1" :class="{ 'open': openPages }"
                @click="openPages = !openPages">
            <span class="nav-icon">📄</span>
            Pages du site
            <svg class="nav-chevron" :class="{ 'rotated': openPages }"
                 width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="openPages" x-collapse style="display:none">
            <a href="{{ route('admin.page-heroes.index') }}"
               class="nav-sub-item {{ request()->routeIs('admin.page-heroes.*') ? 'active' : '' }}">
                <span class="nav-sub-dot"></span> Images Hero
            </a>
            <a href="{{ route('admin.about.index') }}"
               class="nav-sub-item {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
                <span class="nav-sub-dot"></span> Hero & Histoire
            </a>
            <a href="{{ route('admin.valeurs.index') }}"
               class="nav-sub-item {{ request()->routeIs('admin.valeurs.*') ? 'active' : '' }}">
                <span class="nav-sub-dot"></span> Valeurs
            </a>
            <a href="{{ route('admin.equipe.index') }}"
               class="nav-sub-item {{ request()->routeIs('admin.equipe.*') ? 'active' : '' }}">
                <span class="nav-sub-dot"></span> Équipe de direction
            </a>

            <a href="{{ route('admin.mot-directeur.edit') }}"
            class="nav-sub-item {{ request()->routeIs('admin.mot-directeur.*') ? 'active' : '' }}">
                <span class="nav-sub-dot"></span> Mot du directeur
            </a>
        </div>

        {{-- ── Gestion ── --}}
        <div class="nav-section-label mt-2">Gestion</div>

        <a href="{{ route('admin.preinscriptions.index') }}"
           class="nav-item {{ request()->routeIs('admin.preinscriptions.*') ? 'active' : '' }}">
            <span class="nav-icon">✏️</span>
            Préinscriptions
            @php $pendingCount = \App\Models\Preinscription::where('statut','en_attente')->count(); @endphp
            @if($pendingCount > 0)
                <span class="nav-badge">{{ $pendingCount }}</span>
            @endif
        </a>

        <a href="{{ route('admin.documents.index') }}"
           class="nav-item {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">
            <span class="nav-icon">📂</span>
            Documents
        </a>


    <a href="{{ route('admin.contacts.index') }}"
   class="nav-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
    <span class="nav-icon">✉️</span>
    Messages
    @php $nonLusCount = \App\Models\Contact::where('lu', false)->count(); @endphp
    @if($nonLusCount > 0)
        <span class="nav-badge">{{ $nonLusCount }}</span>
    @endif
</a>

<a href="{{ route('admin.newsletter.index') }}" 
   class="nav-link {{ request()->routeIs('admin.newsletter*') ? 'active' : '' }}"
   style="color: white !important;">
    <span>📬</span>
    <span>Newsletter</span>
</a>

        {{-- ── Configuration ── --}}
        <div class="nav-section-label mt-2">Configuration</div>

        <a href="{{ route('admin.parametres.index') }}"
           class="nav-item {{ request()->routeIs('admin.parametres.*') ? 'active' : '' }}">
            <span class="nav-icon">⚙️</span>
            Paramètres école
        </a>

        {{-- Séparateur --}}
        <div style="border-top:1px solid rgba(255,255,255,0.06);margin:14px 0"></div>

        {{-- Voir le site --}}
        <a href="{{ route('home', ['locale' => 'fr']) }}" target="_blank" class="nav-item">
            <span class="nav-icon">🌐</span>
            Voir le site
            <svg class="ml-auto w-3 h-3 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
        </a>

        {{-- Déconnexion --}}
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="nav-item">
                <span class="nav-icon">🚪</span>
                Déconnexion
            </button>
        </form>

    </nav>

    {{-- Profil admin en bas --}}
    <div style="padding:14px 16px;border-top:1px solid rgba(255,255,255,0.06);flex-shrink:0">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                 style="background:linear-gradient(135deg,#2952f5,#152dd4);color:#fff">
                {{ mb_strtoupper(mb_substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div class="min-w-0">
                <div class="text-white text-xs font-semibold truncate">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="text-xs truncate" style="color:rgba(255,255,255,0.35)">{{ auth()->user()->email ?? '' }}</div>
            </div>
        </div>
    </div>

</aside>

{{-- ═══════════════════════════════════
     MAIN CONTENT
═══════════════════════════════════ --}}
<div class="main-content">

    {{-- Topbar --}}
    <header class="topbar">
        <button class="lg:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors"
                @click="sidebarOpen = !sidebarOpen">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <div class="hidden lg:flex items-center gap-2 text-sm text-gray-500">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Admin</a>
            <span>/</span>
            <span class="text-gray-800 font-medium">@yield('breadcrumb', 'Dashboard')</span>
        </div>

        <div class="flex items-center gap-3 ml-auto">
            <span class="hidden md:block text-xs text-gray-400">
                {{ now()->translatedFormat('l d F Y') }}
            </span>
            <a href="{{ route('home', ['locale' => 'fr'])  }}" target="_blank"
               class="hidden md:inline-flex items-center gap-1.5 text-xs font-medium text-gray-500
                      hover:text-blue-600 transition-colors px-3 py-1.5 rounded-lg hover:bg-blue-50">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Voir le site
            </a>
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                 style="background:linear-gradient(135deg,#2952f5,#152dd4)">
                {{ mb_strtoupper(mb_substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
        </div>
    </header>

    {{-- Page content --}}
    <main class="page-content">

        @if(session('success'))
        <div class="alert-success mb-6 flex items-center gap-2">
            ✅ {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert-error mb-6 flex items-center gap-2">
            ❌ {{ session('error') }}
        </div>
        @endif

        @yield('content')

    </main>
</div>

@stack('scripts')
</body>
</html>