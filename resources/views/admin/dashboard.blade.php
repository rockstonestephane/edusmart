@extends('admin.layouts.admin')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')

{{-- En-tête --}}
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">
            Bonjour, {{ auth()->user()->name }} 👋
        </h1>
        <p class="text-gray-500 text-sm mt-1">
            Voici un aperçu de votre site — {{ now()->translatedFormat('l d F Y') }}
        </p>
    </div>
    <a href="{{ route('home', ['locale' => 'fr'])  }}" target="_blank" class="btn-outline">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
        </svg>
        Voir le site
    </a>
</div>

{{-- ── Stats principales ── --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-8">

    @foreach([
        ['label' => 'Hero Slides',     'value' => $stats['hero_slides'],     'icon' => '🖼️',  'color' => '#2952f5', 'route' => 'admin.hero-slides.index'],
        ['label' => 'Actualités',      'value' => $stats['actualites'],      'icon' => '📰',  'color' => '#7c3aed', 'route' => 'admin.actualites.index'],
        ['label' => 'Formations',      'value' => $stats['formations'],      'icon' => '📚',  'color' => '#059669', 'route' => 'admin.formations.index'],
        ['label' => 'Photos galerie',  'value' => $stats['galerie'],         'icon' => '🎨',  'color' => '#d97706', 'route' => 'admin.galerie.index'],
    ] as $stat)
    <a href="{{ route($stat['route']) }}" class="stat-card block">
        <div class="flex items-center justify-between mb-3">
            <span class="text-2xl">{{ $stat['icon'] }}</span>
            <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                 style="background:{{ $stat['color'] }}20">
                <svg class="w-4 h-4" fill="none" stroke="{{ $stat['color'] }}" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </div>
        </div>
        <div class="text-3xl font-bold text-gray-800 mb-1">{{ $stat['value'] }}</div>
        <div class="text-sm text-gray-500">{{ $stat['label'] }}</div>
    </a>
    @endforeach

</div>

{{-- ── Préinscriptions (highlight) ── --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">

    <a href="{{ route('admin.preinscriptions.index') }}" class="stat-card block"
       style="border-left: 4px solid #2952f5">
        <div class="text-2xl mb-2">✏️</div>
        <div class="text-3xl font-bold text-gray-800 mb-1">{{ $stats['preinscriptions'] }}</div>
        <div class="text-sm text-gray-500">Total préinscriptions</div>
    </a>

    <a href="{{ route('admin.preinscriptions.index') }}?statut=en_attente" class="stat-card block"
       style="border-left: 4px solid #f59e0b">
        <div class="text-2xl mb-2">⏳</div>
        <div class="text-3xl font-bold text-gray-800 mb-1">{{ $stats['preinscriptions_attente'] }}</div>
        <div class="text-sm text-gray-500">En attente de traitement</div>
        @if($stats['preinscriptions_attente'] > 0)
        <span class="badge badge-yellow mt-2">Action requise</span>
        @endif
    </a>

    <a href="{{ route('admin.preinscriptions.index') }}?statut=validee" class="stat-card block"
       style="border-left: 4px solid #10b981">
        <div class="text-2xl mb-2">✅</div>
        <div class="text-3xl font-bold text-gray-800 mb-1">{{ $stats['preinscriptions_validees'] }}</div>
        <div class="text-sm text-gray-500">Préinscriptions validées</div>
    </a>

</div>

{{-- ── Deux colonnes : préinscriptions + accès rapides ── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Dernières préinscriptions --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Dernières préinscriptions</h3>
            <a href="{{ route('admin.preinscriptions.index') }}"
               class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                Voir tout →
            </a>
        </div>
        <div class="divide-y divide-gray-50">
            @forelse($dernières_preinscriptions as $p)
            <div class="flex items-center justify-between px-6 py-3">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                         style="background:linear-gradient(135deg,#2952f5,#152dd4)">
                        {{ mb_strtoupper(mb_substr($p->prenom ?? 'E', 0, 1)) }}
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-gray-800">
                            {{ $p->prenom }} {{ $p->nom }}
                        </div>
                        <div class="text-xs text-gray-400">{{ $p->classe_demandee ?? '—' }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    @php
                        $statutClass = match($p->statut ?? 'en_attente') {
                            'validee'  => 'badge-green',
                            'refusee'  => 'badge-red',
                            default    => 'badge-yellow',
                        };
                        $statutLabel = match($p->statut ?? 'en_attente') {
                            'validee'  => 'Validée',
                            'refusee'  => 'Refusée',
                            default    => 'En attente',
                        };
                    @endphp
                    <span class="badge {{ $statutClass }}">{{ $statutLabel }}</span>
                    <a href="{{ route('admin.preinscriptions.show', $p->id) }}"
                       class="text-gray-400 hover:text-blue-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
            @empty
            <div class="px-6 py-8 text-center text-gray-400 text-sm">
                Aucune préinscription pour le moment
            </div>
            @endforelse
        </div>
    </div>

    {{-- Accès rapides --}}
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-800">Accès rapides</h3>
        </div>
        <div class="p-6 grid grid-cols-2 gap-3">
            @foreach([
                ['➕ Nouveau slide',       route('admin.hero-slides.create'),   '#eff6ff', '#2563eb'],
                ['➕ Nouvelle actualité',  route('admin.actualites.create'),    '#f5f3ff', '#7c3aed'],
                ['➕ Nouvelle formation',  route('admin.formations.create'),    '#f0fdf4', '#16a34a'],
                ['➕ Ajouter une photo',   route('admin.galerie.create'),       '#fffbeb', '#d97706'],
                ['➕ Témoignage',          route('admin.temoignages.create'),   '#fdf2f8', '#9d174d'],
                ['⚙️ Paramètres école',   route('admin.parametres.index'),     '#f9fafb', '#374151'],
            ] as [$label, $href, $bg, $color])
            <a href="{{ $href }}"
               class="flex items-center gap-2 p-3 rounded-xl text-sm font-semibold transition-all hover:-translate-y-0.5"
               style="background:{{ $bg }};color:{{ $color }}">
                {{ $label }}
            </a>
            @endforeach
        </div>
    </div>

</div>

@endsection