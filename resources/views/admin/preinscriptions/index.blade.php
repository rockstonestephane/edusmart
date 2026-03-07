@extends('admin.layouts.admin')
@section('title', 'Préinscriptions')
@section('breadcrumb', 'Préinscriptions')

@section('content')

<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Préinscriptions</h1>
        <p class="text-sm text-gray-500 mt-1">{{ $counts['total'] }} préinscription(s) au total</p>
    </div>
</div>

{{-- Stats rapides --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['label' => 'Total',        'value' => $counts['total'],      'class' => 'badge-blue',   'statut' => ''],
        ['label' => 'En attente',   'value' => $counts['en_attente'], 'class' => 'badge-yellow', 'statut' => 'en_attente'],
        ['label' => 'Validées',     'value' => $counts['validee'],    'class' => 'badge-green',  'statut' => 'validee'],
        ['label' => 'Refusées',     'value' => $counts['refusee'],    'class' => 'badge-red',    'statut' => 'refusee'],
    ] as $s)
    <a href="{{ route('admin.preinscriptions.index', $s['statut'] ? ['statut' => $s['statut']] : []) }}"
       class="stat-card block text-center">
        <div class="text-2xl font-bold text-gray-800 mb-1">{{ $s['value'] }}</div>
        <span class="badge {{ $s['class'] }}">{{ $s['label'] }}</span>
    </a>
    @endforeach
</div>

{{-- Filtres --}}
<div class="bg-white rounded-2xl border border-gray-100 p-4 mb-5">
    <form method="GET" action="{{ route('admin.preinscriptions.index') }}"
          class="flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-48">
            <label class="form-label">Rechercher</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Nom, prénom, email..."
                   class="form-input">
        </div>
        <div class="w-48">
            <label class="form-label">Statut</label>
            <select name="statut" class="form-select">
                <option value="">-- Tous --</option>
                @foreach(\App\Models\Preinscription::STATUTS as $val => $label)
                <option value="{{ $val }}" {{ request('statut') == $val ? 'selected' : '' }}>
                    {{ $label }}
                </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-primary">🔍 Filtrer</button>
        <a href="{{ route('admin.preinscriptions.index') }}" class="btn-outline">
            Réinitialiser
        </a>
    </form>
</div>

@if($preinscriptions->isEmpty())
<div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
    <div class="text-5xl mb-4">✏️</div>
    <h3 class="font-bold text-gray-700 mb-2">Aucune préinscription trouvée</h3>
    <p class="text-gray-400 text-sm">Les préinscriptions soumises depuis le site apparaîtront ici.</p>
</div>
@else
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Élève</th>
                <th>Classe demandée</th>
                <th>Parent / Contact</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($preinscriptions as $p)
            <tr>
                <td class="text-xs text-gray-400">
                    {{ $p->created_at->format('d/m/Y') }}<br>
                    <span class="text-gray-300">{{ $p->created_at->format('H:i') }}</span>
                </td>
                <td>
                    <div class="font-semibold text-gray-800 text-sm">
                        {{ $p->prenom }} {{ $p->nom }}
                    </div>
                    <div class="text-xs text-gray-400">
                        {{ $p->date_naissance?->format('d/m/Y') }}
                        {{ $p->sexe ? '· ' . ucfirst($p->sexe) : '' }}
                    </div>
                </td>
                <td>
                    <span class="badge badge-blue">{{ $p->classe_demandee ?? '—' }}</span>
                    @if($p->annee_scolaire)
                    <div class="text-xs text-gray-400 mt-1">{{ $p->annee_scolaire }}</div>
                    @endif
                </td>
                <td>
                    <div class="text-sm text-gray-700">{{ $p->nom_parent }}</div>
                    <div class="text-xs text-gray-400">{{ $p->telephone_parent }}</div>
                    <div class="text-xs text-gray-400">{{ $p->email_parent }}</div>
                </td>
                <td>
                    @php
                        $statutClass = match($p->statut) {
                            'validee'  => 'badge-green',
                            'refusee'  => 'badge-red',
                            'en_cours' => 'badge-blue',
                            default    => 'badge-yellow',
                        };
                    @endphp
                    <span class="badge {{ $statutClass }}">
                        {{ \App\Models\Preinscription::STATUTS[$p->statut] ?? $p->statut }}
                    </span>
                </td>
                <td>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.preinscriptions.show', $p->id) }}"
                           class="btn-edit">👁️ Voir</a>
                        <form method="POST"
                              action="{{ route('admin.preinscriptions.destroy', $p->id) }}"
                              onsubmit="return confirm('Supprimer cette préinscription ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger">🗑️</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $preinscriptions->links() }}
    </div>
</div>
@endif

@endsection